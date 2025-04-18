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
		dd(settings('link_admin'));
	}
}