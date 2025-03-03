<?php

namespace App\Models;

/**
 * @property mixed|null $title
 * @property mixed|null $description
 * @property mixed|null $date
 * @property int|mixed|null $active
 * @property mixed|null $prize
 *
 * @property mixed|string|null $hash
 * @property mixed|null $winners
 * @property false|mixed|string|null $conditions
 * @property mixed|null $sponsor_title
 * @property mixed|null $sponsor_url
 */
class Draw extends Model
{
	protected $table = 'draws';
	protected $fields = [
		'date', 'active', 'prize', 'title', 'description', 'hash', 'winners', 'status', 'conditions', 'sponsor_title', 'sponsor_url'
	];
}