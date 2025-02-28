<?php

namespace App\Utility;

use App\Api\API;
use App\Api\RequestHandler;
use Random\RandomException;

class Websocket extends API
{
    /**
     * @throws RandomException
     */
    public function onMessage($data, $connection, $clients = [])
    {
        $data = $this->webSocket($data);
        if (!empty($data)) {
            $handler = new RequestHandler($data);
            switch ($data->type) {
                case 'auth':
                    $connection->send(json_encode([
                        'sc' => true,
                        'user' => $handler->authorizationRegistration()])
                    );
                    break;
            }
        }
    }
}