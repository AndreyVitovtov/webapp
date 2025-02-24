<?php

namespace App\Controllers;

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
		foreach ($request as $key => $value) {
			$settings = (new \App\Models\Settings())->getOneObject(['key' => $key]);
			$settings->value = $value;
			$settings->update();
		}
		redirect('/settings', [
			'message' => __('changes saved')
		]);
	}
}