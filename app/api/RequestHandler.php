<?php

namespace app\api;

use Random\RandomException;

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
            $user = $this->existsUser($this->data);
            if (!empty($user)) {
                return $this->updateToken($user);
            } else {
                $user = $this->register($this->data);
            }
        }
        return $user ?? null;
    }
}