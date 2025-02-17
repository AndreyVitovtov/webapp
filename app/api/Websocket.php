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


					$data = [
						'sc' => true,
						'type' => 'page',
						'page' => $handler->data->page,
						'html' => $handler->getPage(),
						'token' => $handler->data->token
					];

//					if($handler->data->page == 'index') {
//						$data['mainButtonText'] = __('main button text', $user->languageCode);
//						$data['mainButtonUrl'] = 'https://google.com';
//					}

                    $connection->send(json_encode($data));
                    break;
            }
        }
    }
}