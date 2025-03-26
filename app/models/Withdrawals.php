<?php

namespace App\Models;

/**
 * @property false|mixed|string|null $user_id
 * @property int|mixed|null $balance
 * @property mixed|null $wallet
 * @property mixed|null $status
 */
class Withdrawals extends Model
{
	protected $table = 'withdrawals';
	protected $fields = [
		'user_id', 'balance', 'wallet', 'status'
	];
}