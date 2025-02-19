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
                    $user = (new User())->getOneObject(['token' => $handler->data->token]);

                    $data = [
                        'sc' => true,
                        'type' => 'page',
                        'page' => $handler->data->page,
                        'html' => $handler->getPage()
                    ];

                    if ($handler->data->page == 'index') {
                        $data['mainButton'] = [
                            'text' => __('invite participants', [], $handler->getLanguageCode($user)),
                            'url' => 'https://t.me/share/url?url=' . rawurlencode(BOT_APP_LINK . '?startapp=' . $user->chat_id) . '&text=' . rawurlencode(__('invite text', [], $handler->getLanguageCode($user)))
                        ];
                        $activeDraw = $handler->getActiveDraw();
                        $drawId = $activeDraw->id ?? 0;
                        if (!empty($drawId)) {
                            $activeDraw->title = json_decode($activeDraw->title);
                            $activeDraw->description = json_decode($activeDraw->description);
                            $data['draw'] = [
                                'title' => $activeDraw->title->{$handler->getLanguageCode($user)},
                                'description' => $activeDraw->description->{$handler->getLanguageCode($user)},
                                'prize' => $activeDraw->prize,
                                'date' => date('Y-m-d\TH:i:s', strtotime($activeDraw->date))
                            ];
                        }
                    }

                    $connection->send(json_encode($data));
                    break;
            }
        }
    }
}