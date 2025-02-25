<?php

namespace App\Api;

use App\Models\User;
use App\Utility\TelegramWebApp;
use Random\RandomException;

class Websocket extends API
{
    /**
     * @throws RandomException
     */
    public function onMessage($data, $connection, &$clients = []): void
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
                    if (method_exists($handler::class, $method = 'page' . ucfirst($handler->data->page))) {
                        $responseData = [];
                        $user = (new User())->getOneObject(['token' => $handler->data->token]);
                        if (empty($user)) {
                            $connection->send(json_encode([
                                'sc' => false,
                                'error' => 'Not found'
                            ]));
                            break;
                        }
                        $handler->$method($user, $responseData);
                    }

                    $responseData = array_merge($responseData ?? [], [
                        'sc' => true,
                        'type' => 'page',
                        'page' => $handler->data->page,
                        'html' => $handler->getPage($responseData ?? [])
                    ]);

                    $connection->send(json_encode($responseData));
                    break;
                default:
                    $connection->send(json_encode([
                        'sc' => false,
                        'error' => 'Not found'
                    ]));
                    break;
            }
        }
    }
}