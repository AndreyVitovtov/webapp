<?php

namespace App\Models;

class Balance extends Model
{
	protected $table = 'balances';
	protected $fields = [
		'user_id', 'balance'
	];
}