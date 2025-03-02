<?php

namespace App\Controllers;

class Airdrop extends Controller
{
	public function all(): void
	{
		$this->view('index', [
			'title' => __('airdrops'),
			'pageTitle' => __('airdrops')
		]);
	}

	public function add()
	{
		$this->view('add', [
			'title' => __('add airdrop'),
			'pageTitle' => __('add airdrops')
		]);
	}
}