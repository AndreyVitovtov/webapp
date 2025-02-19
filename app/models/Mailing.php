<?php

namespace App\Models;

/**
 * @property mixed|null $users
 * @property mixed|null $language
 * @property mixed|null $image
 * @property mixed|null $text
 * @property mixed|null $start
 * @property false|mixed|string|null $completed
 * @property mixed|null $min_id
 */
class Mailing extends Model
{
	protected $table = 'mailing';
	protected $fields = [
		'language',
		'text',
		'image',
		'added',
		'start',
		'completed',
		'min_id'
	];
}