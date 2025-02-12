<?php

namespace App\Models;

/**
 * @property mixed|string|null $token
 * @property mixed|null $chatId
 * @property false|string $id
 */
class User extends Model
{
    protected $table = 'users';
    protected $fields = [
        'chatId', 'username', 'firstName', 'lastName', 'token', 'languageCode', 'photoUrl'
    ];
}