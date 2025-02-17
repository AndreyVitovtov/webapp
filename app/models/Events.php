<?php

namespace App\Models;

class Events extends Model
{
	protected $table = 'events';
	protected $fields = [
		'title', 'date', 'active'
	];
}