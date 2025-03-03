<?php

namespace App\Models;

/**
 * @property mixed|null $draw_id
 * @property mixed|null $user_id
 * @property mixed|null $prize
 * @property mixed|null $prize_referrer
 * @property mixed|null $coefficient
 * @property mixed|null $percentage_referrer
 */
class Winner extends Model
{
	protected $table = 'winners';
	protected $fields = [
		'draw_id', 'user_id', 'prize', 'prize_referrer', 'coefficient', 'percentage_referrer', 'paid_out'
	];
}