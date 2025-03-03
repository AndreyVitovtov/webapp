<?php

namespace App\Controllers;

use App\Utility\Redis;

class Test extends Controller
{
	public function index()
	{
		$res = (json_decode(Redis::get('drawCompleted'), true));
		extract(['winners' => $res[2]]);
		dd($winners);
	}
}