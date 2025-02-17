<?php

namespace App\Controllers;

class WebApp extends Controller
{
	public function index()
	{
		$this->view('content', [
			'title' => 'Web App',
			'content' => 'Hello World!',
			'assetsURL' => [
				'js' => [
					'https://telegram.org/js/telegram-web-app.js?56',
//					'https://unpkg.com/@tonconnect/ui@latest/dist/tonconnect-ui.min.js'
				]
			],
			'assets' => [
				'js' => [
					'web-app/timer.js',
					'web-app/app.js',
					'web-app/requestHandler.js',
					'web-app/websocket.js',
//					'web-app/ton.js',
				],
				'css' => 'animate.min.css'
			]
		]);
	}
}