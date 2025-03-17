<?php

namespace App\Controllers;

use App\Api\DeterminationWinners;
use App\Models\Channel;
use App\Models\Draw;
use App\Models\WinnersDraw;
use App\Utility\Request;

class Draws extends Controller
{
	public function all(): void
	{
		$this->auth();
		$draws = (new Draw())->getObjects([], 'AND', 'id', 'DESC');
		$this->view('all', [
			'title' => __('draws'),
			'pageTitle' => __('draws'),
			'draws' => array_map(function ($draw) {
				$draw->title = json_decode($draw->title);
				$draw->description = json_decode($draw->description);
				$draw->link = BOT_APP_LINK . '?startapp=draw-' . $draw->hash;
				return $draw;
			}, $draws),
			'assets' => [
				'js' => 'draws.js'
			]
		]);
	}

	public function add(): void
	{
		$this->auth()->view('add', [
			'title' => __('add draw'),
			'pageTitle' => __('add draw'),
			'assets' => [
				'js' => [
					'draws.js',
					'dataTables.min.js'
				],
				'css' => [
					'users.css',
					'dataTables.dataTables.min.css'
				]
			],
			'users' => (new \App\Models\User())->getObjects([
				'active' => 1
			])
		]);
	}

	private function updateActive(): void
	{
		$draw = new Draw();
		$draw->query('UPDATE draws SET active = 0');
	}

	public function addSave(Request $request): void
	{
		$this->auth();
		$active = ($request->active ? 1 : 0);
		$hash = $this->generateHash();
//        if ($active) $this->updateActive();
		$draw = new Draw();
		$draw->title = json_encode($request->title);
		$draw->description = json_encode($request->description);
		$draw->date = $request->date;
		$draw->active = $active;
		$draw->hash = $hash;
		$draw->prize = $request->prize;
		$draw->winners = $request->winners;
		$draw->insert();

		$selectedWinners = $request->get('selected-winners');
		if (!empty($selectedWinners)) {
			foreach ($selectedWinners as $winner) {
				$winnersDraw = (new WinnersDraw());
				$winnersDraw->draw_id = $draw->id;
				$winnersDraw->user_id = $winner;
				$winnersDraw->insert();
			}
		}

		redirect('/draws/all', [
			'message' => __('draw added')
		]);
	}

	public function edit($id): void
	{
		$this->auth();
		$draw = new Draw();
		$draw = $draw->find($id);
		$draw->title = @json_decode($draw->title);
		$draw->description = @json_decode($draw->description);
		$this->view('edit', [
			'title' => __('edit draw'),
			'pageTitle' => __('edit draw'),
			'draw' => $draw,
			'assets' => [
				'js' => [
					'draws.js',
					'dataTables.min.js'
				],
				'css' => [
					'users.css',
					'dataTables.dataTables.min.css'
				]
			],
			'users' => (new \App\Models\User())->getObjects([
				'active' => 1
			]),
			'winnersDraw' => (new WinnersDraw())->query(
				"SELECT u.`id`, 
       						u.`username`, 
       						u.`first_name`, 
       						u.`last_name`
				FROM `winners_draw` d,
				     `users` u
				WHERE d.`user_id` = u.`id`
	          	AND d.`draw_id` = :drawId
			", [
				'drawId' => $id
			], true)
		]);
	}

	public function editSave(Request $request): void
	{
		$this->auth();
		$active = ($request->active ? 1 : 0);
//        if ($active) $this->updateActive();
		$draw = new Draw();
		$draw->find($request->id);
		$draw->title = json_encode($request->title);
		$draw->description = json_encode($request->description);
		$draw->date = $request->date;
		$draw->active = $active;
		$draw->prize = $request->prize;
		$draw->winners = $request->winners;
		$draw->update();

		(new WinnersDraw())->query("
			DELETE FROM `winners_draw` 
       		WHERE draw_id = :drawId
        ", [
			'drawId' => $draw->id
		]);

		$selectedWinners = $request->get('selected-winners');
		if (!empty($selectedWinners)) {
			foreach ($selectedWinners as $winner) {
				$winnersDraw = (new WinnersDraw());
				$winnersDraw->draw_id = $draw->id;
				$winnersDraw->user_id = $winner;
				$winnersDraw->insert();
			}
		}

		redirect('/draws/all', [
			'message' => __('draw edited')
		]);
	}

	public function delete(Request $request): void
	{
		$this->auth();

		(new Channel)->query('DELETE FROM `channels` WHERE draw_id = :drawId', [
			'drawId' => $request->id
		]);

		(new Draw())->delete($request->id);
		redirect('/draws/all', [
			'message' => __('draw deleted')
		]);

	}

	private function generateHash($length = 12): string
	{
		return substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes($length))), 0, $length);
	}

	public function execute()
	{
		$draw = (new Draw())->query("
			SELECT *
			FROM `draws`
			WHERE `date` <= NOW()
			AND `active` = 1
			AND `status` = 'IN PROGRESS'
			ORDER BY `date`
			LIMIT 1
		", [], true)[0] ?? [];
		if (!empty($draw)) {
			$draw = (new Draw())->find($draw['id']);
			$draw->status = 'DETERMINING WINNERS';
			$draw->update();

			(new UpdateCoefficients)->index($draw->id);

			(new DeterminationWinners)->execute($draw->id, $draw->winners);

			$draw->status = 'COMPLETED';
			$draw->update();
		}
	}
}