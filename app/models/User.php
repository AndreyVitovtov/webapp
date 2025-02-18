<?php

namespace App\Models;

/**
 * @property mixed|string|null $token
 * @property mixed|null $chat_id
 * @property false|string $id
 * @property mixed|null $referrer_id
 * @property mixed|string|null $username
 * @property mixed|string|null $first_name
 * @property mixed|string|null $last_name
 * @property mixed|string|null $language_code
 * @property mixed|string|null $photo_url
 */
class User extends Model
{
	protected $table = 'users';
	protected $fields = [
		'chat_id', 'username', 'first_name', 'last_name', 'token', 'language_code', 'photo_url', 'referrer_id', 'active'
	];
}