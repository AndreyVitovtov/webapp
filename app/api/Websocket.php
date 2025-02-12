<?php

namespace App\Api;

use App\Utility\TelegramWebApp;
use Random\RandomException;

class Websocket extends API
{
    /**
     * @throws RandomException
     */
    public function onMessage($data, $connection, &$clients = [])
    {
        $data = $this->webSocket($data);
        if (!empty($data)) {
            $handler = new RequestHandler($data);
            switch ($data->type) {
                case 'auth':
                    if (!TelegramWebApp::validatingData($data->data->initData)) {
                        $connection->send(json_encode([
                            'sc' => false,
                            'type' => 'auth'
                        ]));
                        return;
                    } else {
                        $user = $handler->authorizationRegistration();
                        $clients[$connection->id] = [
                            'connection' => $connection,
                            'user' => $user
                        ];
                        $connection->send(json_encode([
                            'sc' => true,
                            'type' => 'auth',
                            'token' => $user->token
                        ]));
                    }
                    break;
                case 'getPage':
                    $connection->send(json_encode([
                        'sc' => true,
                        'type' => 'page',
                        'html' => $handler->getPage()
                    ]));
                    break;
            }
        }
    }
}