<?php

namespace App\Models;

/**
 * @property mixed|null $chat_id
 * @property mixed|null $message_id
 */
class BotMessages extends Model
{
	protected $table = 'bot_messages';
	protected $fields = ['chat_id', 'message_id'];
}