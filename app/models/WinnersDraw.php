<?php

namespace App\Models;

/**
 * @property false|mixed|string|null $draw_id
 * @property mixed|null $user_id
 */
class WinnersDraw extends Model
{
	protected $table = 'winners_draw';
	protected $fields = [
		'user_id', 'draw_id'
	];
}