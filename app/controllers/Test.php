<?php

namespace App\Controllers;

use App\Models\Channel;
use App\Models\User;
use App\Utility\Database;
use App\Utility\Redis;
use App\Utility\TelegramBot;

class Test extends Controller
{
	public function index()
	{
		$data['channels'] = (new Channel())->getObjects([
			'draw_id' => 29,
			'language' => 'ru'
		]);
		$telegram = new TelegramBot(TELEGRAM_TOKEN);
		foreach ($data['channels'] as $key => $channel) {
			$chatMember = @json_decode($telegram->getChatMember(trim('847669358'), trim($channel->chat_id)));
			$data['channels'][$key]->subscribe = $chatMember->result->status !== 'left';
		}
		dd($data);
	}
}