<?php

namespace App\Api;

use App\Models\User;
use Random\RandomException;
use stdClass;

class RequestHandler extends API
{
    private mixed $data;

    public function __construct($data)
    {
        $this->data = $this->webSocket($data);
    }

    /**
     * @throws RandomException
     */
    public function authorizationRegistration(): ?\App\Models\User
    {
        if (!empty($this->data)) {
            $user = $this->existsUser($this->data->data->user);
            $userId = $user->id;
            if (!empty($userId)) {
                return $this->updateToken($user);
            } else {
                $user = $this->register($this->data->data->user);
            }
        }
        return $user ?? null;
    }

    public function getPage(): string
    {
        $page = $this->data->page;
        if (!empty($page)) {
            return html('Webapp/' . $page . '.php', [
                'content' => 'Test page'
            ]);
        } else {
            return 'No page found';
        }
    }
}