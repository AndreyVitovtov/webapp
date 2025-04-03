<?php

namespace App\Controllers;

use App\Utility\Request;

class Texts extends Controller
{
	public function ru(): void
	{
		$this->languages('ru');
	}

	public function en(): void
	{
		$this->languages('en');
	}

	private function languages($lang): void
	{
		$this->auth()->view('index', [
			'title' => 'Texts',
			'pageTitle' => 'Texts',
			'lang' => $lang,
			'texts' => json_decode(file_get_contents(data('lang/' . $lang . '.json'))),
			'assets' => [
				'js' => 'texts.js'
			]
		]);
	}

	public function save(): void
	{
		$texts = json_decode(file_get_contents("php://input"), true);
		$lang = $texts['lang'];
		unset($texts['lang']);

		file_put_contents(data('lang/' . $lang . '.json'), json_encode($texts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

		echo json_encode([
			"status" => "ok",
			"message" => __('texts saved')
		]);
	}
}