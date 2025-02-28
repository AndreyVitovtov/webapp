<?php

namespace App\Models;

/**
 * @property mixed|null $title
 * @property mixed|null $url
 * @property mixed|null $chat_id
 * @property mixed|null $language
 * @property mixed|null $draw_id
 * @property mixed|null $type
 */
class Channel extends Model
{
	protected $table = 'channels';
	protected $fields = [
		'title', 'chat_id', 'url', 'language', 'draw_id', 'type'
	];
}