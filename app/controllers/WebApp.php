<?php

namespace App\Controllers;

class WebApp extends Controller
{
	public function index()
	{
		$this->view('content', [
			'title' => 'Web App',
			'content' => 'Loading...',
			'assetsURL' => [
				'js' => [
					'https://telegram.org/js/telegram-web-app.js?56',
//					'https://unpkg.com/@tonconnect/ui@latest/dist/tonconnect-ui.min.js',
					'https://unpkg.com/@tonconnect/sdk@latest/dist/tonconnect-sdk.min.js'
				]
			],
			'assets' => [
				'js' => [
					'web-app/lottie.min.js',
					'web-app/app.js',
					'web-app/functions.js',
					'web-app/timer.js',
					'web-app/requestHandler.js',
					'web-app/websocket.js'
				],
				'css' => 'animate.min.css'
			]
		]);
	}
}