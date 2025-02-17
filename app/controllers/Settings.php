<?php

namespace App\Controllers;

use App\Utility\Request;

class Settings extends Controller
{
	public function index(): void
	{
		$this->view('index', [
			'title' => __('Settings'),
			'pageTitle' => __('Settings'),
			'settings' => (new \App\Models\Settings)->getObjects()
		]);
	}

	public function save(Request $request): void
	{
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