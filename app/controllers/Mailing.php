<?php

namespace App\Controllers;

use App\Models\User;
use App\Utility\Curl;
use App\Utility\Request;

class Mailing extends Controller
{
	public function index(): void
    {
		$mailing = (new \App\Models\Mailing())->get([], '', 'id', 'DESC');
		$this->auth()->view('index', [
			'title' => __('mailing'),
			'pageTitle' => __('mailing'),
			'mailing' => $mailing
		]);
	}

	public function add(): void
    {
		$this->auth()->view('add', [
			'title' => __('add mailing'),
			'pageTitle' => __('add mailing'),
		]);
	}

	public function addSave(Request $request): void
    {
		$mailing = new \App\Models\Mailing();
		$imageUrl = $request->imageUrl;
		$mailing->language = $request->language;
		$mailing->text = $request->text;
		if (!empty($imageUrl)) {
			$mailing->image = $imageUrl;
		} elseif (!empty($_FILES['image']['name'])) {
			$fileName = $_FILES['image']['name'];
			$fileSize = $_FILES['image']['size'];
			$fileTmp = $_FILES['image']['tmp_name'];
			$fileExt = explode('.', $fileName);
			$fileExt = strtolower(end($fileExt));
			$fileName = md5(user('id') . time()) . '.' . $fileExt;

			if ($fileSize > (MAX_SIZE_SEND_MESSAGE * 1024 * 1024)) {
				redirect('mailing/add', [
					'error' => __('file size must be less')
				]);
				exit();
			}
			if (!move_uploaded_file($fileTmp, data('images/mailing/' . $fileName))) {
				redirect('mailing/add', [
					'error' => __('failed to upload file')
				]);
				exit();
			} else {
				$mailing->image = BASE_URL . 'app/data/images/mailing/' . $fileName;
				unlink(data('tmp/' . $fileName));
			}
		}
		$mailing->insert();
		redirect('/mailing', [
			'message' => __('mailing added')
		]);
	}

	public function send($token): void
	{
		set_time_limit(0);

		if (!$this->checkToken($token)) die('Invalid token');

		$mailingModel = (new \App\Models\Mailing());
		$mailing = $mailingModel->query("
			SELECT * 
			FROM `mailing`
			WHERE `completed` IS NULL
			ORDER BY `id`
			LIMIT 1
		", [], true)[0] ?? [];

		if (!empty($mailing)) {
			if ($mailing['start'] == null) {
				$mailingModel->find($mailing['id']);
				$mailingModel->start = date('Y-m-d H:i:s');
				$mailingModel->update();
			}

			$filePath = data('logs/mailing/' . $mailing['id']);
			if (file_exists($filePath)) $log = @json_decode(file_get_contents($filePath), true);
			else $log = [];

            if($mailing['language'] == DEFAULT_LANG) {
                $where = [];
                foreach (LANGUAGES as $lang => $language) {
                    if($lang == DEFAULT_LANG) continue;
                    $where[] = "`language_code` != '" . $lang . "'";
                }
                $where = implode(' AND ', $where);
            }
            else $where = "`language_code` = '" . $mailing['language'] . "'";

			$users = (new User)->query("
				SELECT `id`, `chat_id`
				FROM `users`
				WHERE ($where)
				AND `id` > :minId
				ORDER BY `id`
				LIMIT " . MAILING_COUNT_SEND_MESSAGE . "
			", [
				'minId' => $mailing['min_id']
			], true);

			if (empty($users)) {
				$mailingModel->find($mailing['id']);
				$mailingModel->completed = date('Y-m-d H:i:s');
				$mailingModel->update();
			} else {
				$result = (new Curl())->multi(array_combine(array_column($users, 'id'), array_map(function ($u) use ($mailing) {
					return [
						'url' => 'https://api.telegram.org/bot' . TELEGRAM_TOKEN . '/' . (empty($mailing['image']) ? 'sendMessage' : 'sendPhoto'),
						'data' => (empty($mailing['image']) ? [
							'text' => $mailing['text'],
							'chat_id' => $u['chat_id'],
							'parse_mode' => 'HTML',
							'disable_web_page_preview' => false
						] : [
							'chat_id' => $u['chat_id'],
							'photo' => $mailing['image'],
							'caption' => $mailing['text'],
							'parse_mode' => 'HTML'
						])
					];
				}, $users)));

				foreach ($result as $key => $res) {
					$res = @json_decode($res, true);
					if (!empty($res)) $result[$key] = $res;
				}

				$log = $log + $result;
				file_put_contents($filePath, json_encode($log), FILE_APPEND);

				$mailingModel->find($mailing['id']);
				$mailingModel->min_id = max(array_column($users, 'id'));
				$mailingModel->update();
			}
		}
	}

	public function log($id): void
    {
		$filePath = data('logs/mailing/' . $id);
		if (file_exists($filePath)) {
			$log = @json_decode(file_get_contents($filePath), true);
		}

		$this->auth()->view('log', [
			'title' => __('mailing log'),
			'log' => $log ?? []
		]);
	}

	public function delete(Request $request): void
    {
		(new \App\Models\Mailing())->delete($request->id);
		$filePath = data('logs/mailing/' . $request->id);
		if (file_exists($filePath)) {
			unlink($filePath);
		}
		redirect('/mailing');
	}
}