<?php

namespace App\Models;

/**
 * @property mixed|string|null $token
 */
class User extends Model
{
    protected $table = 'users';
    protected $fields = [
        'chatId', 'username', 'firstName', 'lastName', 'token'
    ];
}