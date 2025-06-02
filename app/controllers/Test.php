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
		$telegram = new TelegramBot(TELEGRAM_TOKEN);
		$res = json_decode($telegram->getChatMember('490929240', '-1002534224403'));
		dd($res);
	}
}