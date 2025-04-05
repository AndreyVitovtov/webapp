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
		$user = (new User)->find(1);
		$user->language_code = 'ru';
		if (!in_array($user->language_code, array_keys(LANGUAGES))) echo DEFAULT_LANG;
		echo $user->language_code ?? DEFAULT_LANG;
	}
}