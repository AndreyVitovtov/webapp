<?php

namespace App\Controllers;

use App\Utility\Files;
use App\Utility\Request;

class Airdrop extends Controller
{
	public function all(): void
	{
		$airdrops = (new \App\Models\Airdrop())->getObjects([], 'AND', 'id', 'DESC');
		$this->auth()->view('all', [
			'title' => __('airdrops'),
			'pageTitle' => __('airdrops'),
			'airdrops' => $airdrops
		]);
	}

	public function add(): void
	{
		$this->auth()->view('add', [
			'title' => __('add airdrop'),
			'pageTitle' => __('add airdrops')
		]);
	}

	public function addSave(Request $request): void
	{
		$this->auth();

		$active = ($request->active ? 1 : 0);

		$description = [];
		foreach (LANGUAGES as $key => $lang) {
			$field = 'description_' . $key;
			$description[$key] = $request->$field;
		}

		$airdrop = new \App\Models\Airdrop();
		$airdrop->title = $request->title;
		Files::saveImage('logo', 'airdrops/', $airdrop, '/airdrop/add');
		$airdrop->date = $request->date;
		$airdrop->total = $request->total;
		$airdrop->per_user = $request->per_user;
		$airdrop->max_winners = $request->max_winners;
		$airdrop->channel_draw = $request->channel_draw;
		$airdrop->channel_project_draw = $request->channel_project_draw;
		$airdrop->group_project_draw = $request->group_project_draw;
		$airdrop->description = json_encode($description);
		$airdrop->active = $active;
		$airdrop->insert();

		redirect('/airdrop/all', [
			'message' => __('airdrop added')
		]);
	}

	public function delete(Request $request): void
	{
		$this->auth();

		$airdrop = (new \App\Models\Airdrop())->find($request->id);

		if (file_exists(assets('images/airdrops/' . $airdrop->logo))) {
			unlink(assets('images/airdrops/' . $airdrop->logo));
		}
		$airdrop->delete();

		redirect('/airdrop/all', [
			'message' => __('airdrop deleted')
		]);
	}

	public function edit($id): void
	{
		$this->auth();

		$airdrop = (new \App\Models\Airdrop())->find($id);
		$airdrop->description = @json_decode($airdrop->description);

		$this->view('edit', [
			'title' => __('edit airdrop'),
			'pageTitle' => __('edit airdrop'),
			'airdrop' => $airdrop
		]);
	}

	public function editSave(Request $request)
	{
		$this->auth();

		$active = ($request->active ? 1 : 0);

		$description = [];
		foreach (LANGUAGES as $key => $lang) {
			$field = 'description_' . $key;
			$description[$key] = $request->$field;
		}

		$airdrop = (new \App\Models\Airdrop())->find($request->id);

		$logoAirdrop = $airdrop->logo;

		$airdrop->title = $request->title;
		Files::saveImage('logo', 'airdrops/', $airdrop, '/airdrop/add');

		if (!empty($_FILES['logo']['name'])) {
			unlink(assets('images/airdrops/' . $logoAirdrop));
		}

		$airdrop->date = $request->date;
		$airdrop->total = $request->total;
		$airdrop->per_user = $request->per_user;
		$airdrop->max_winners = $request->max_winners;
		$airdrop->channel_draw = $request->channel_draw;
		$airdrop->channel_project_draw = $request->channel_project_draw;
		$airdrop->group_project_draw = $request->group_project_draw;
		$airdrop->description = json_encode($description);
		$airdrop->active = $active;
		$airdrop->update();

		redirect('/airdrop/all', [
			'message' => __('airdrop edited')
		]);
	}
}