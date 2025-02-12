<?php

namespace App\Controllers;

class WebApp extends Controller
{
    public function index()
    {
        $this->view('index', [
            'title' => 'Web App',
            'content' => 'Hello World!',
            'assetsURL' => [
                'js' => 'https://telegram.org/js/telegram-web-app.js?56'
            ],
            'assets' => [
                'js' => [
                    'web-app/app.js',
                    'web-app/requestHandler.js',
                    'web-app/websocket.js'
                ]
            ]
        ]);
    }
}