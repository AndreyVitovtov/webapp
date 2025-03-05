<?php

namespace App\Controllers;

use App\Utility\Redis;
use App\Utility\Request;

class Settings extends Controller
{
	public function index(): void
	{
		$this->auth()->view('index', [
			'title' => __('settings'),
			'pageTitle' => __('settings'),
			'settings' => (new \App\Models\Settings)->getObjects()
		]);
	}

	public function save(Request $request): void
	{
		$this->auth();
		$request = $request->get();
		$settings = [];
		foreach ($request as $key => $value) {
			$setting = (new \App\Models\Settings())->getOneObject(['key' => $key]);
			$setting->value = $value;
			$setting->update();
			$settings[$key] = $value;
		}
		Redis::set('settings', json_encode($settings));
		redirect('/settings', [
			'message' => __('changes saved')
		]);
	}
}