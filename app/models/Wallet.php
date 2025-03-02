<?php

namespace App\Models;

/**
 * @property false|mixed|string|null $user_id
 */
class Wallet extends Model
{
	protected $table = 'wallets';
	protected $fields = [
		'user_id', 'json', 'address'
	];
}