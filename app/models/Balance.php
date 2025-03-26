<?php

namespace App\Models;

/**
 * @property mixed|null $user_id
 * @property mixed|null $balance
 */
class Balance extends Model
{
	protected $table = 'balances';
	protected $fields = [
		'user_id', 'balance'
	];
}