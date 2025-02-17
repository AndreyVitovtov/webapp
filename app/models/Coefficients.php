<?php

namespace App\Models;

/**
 * @property mixed|null $user_id
 * @property mixed|null $event_id
 * @property int|mixed|null $coefficient
 * @property int|mixed|null $coefficient_admin
 */
class Coefficients extends Model
{
	protected $table = 'coefficients';
	protected $fields = [
		'user_id', 'event_id', 'coefficient', 'coefficient_admin'
	];
}