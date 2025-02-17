<?php

namespace App\Controllers;

use App\Models\Channel;
use App\Utility\Request;

class Channels extends Controller
{
	public function add(): void
	{
		$this->view('add', [
			'title' => __('add channel'),
			'pageTitle' => __('add channel'),
		]);
	}

	public function all(): void
	{
		$this->view('all', [
			'title' => __('channels'),
			'pageTitle' => __('channels'),
			'channels' => (new Channel)->getObjects()
		]);
	}

	public function addSave(Request $request): void
	{
		$channel = new Channel();
		$channel->title = $request->title;
		$channel->url = $request->url;
		$channel->chat_id = $request->chat_id;
		$channel->language = $request->language;
		$channel->insert();
		redirect('/channels/all', [
			'message' => __('channel added')
		]);
	}

	public function edit($id)
	{
		$this->view('edit', [
			'title' => __('edit channel'),
			'pageTitle' => __('edit channel'),
			'channel' => (new Channel)->find($id)
		]);
	}

	public function editSave(Request $request)
	{
		$channel = new Channel();
		$channel->find($request->id);
		$channel->title = $request->title;
		$channel->url = $request->url;
		$channel->chat_id = $request->chat_id;
		$channel->language = $request->language;
		$channel->update();
		redirect('/channels/all', [
			'message' => __('channel edited')
		]);
	}

	public function delete(Request $request)
	{
		$channel = new Channel();
		$channel->delete($request->id);
		redirect('/channels/all', [
			'message' => __('channel deleted')
		]);
	}
}