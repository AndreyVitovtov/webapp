<?php

namespace App\Models;

class Settings extends Model
{
	protected $table = 'settings';
	protected $fields = [
		'key', 'value', 'type'
	];
}