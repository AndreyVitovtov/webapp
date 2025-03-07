<?php

namespace App\Controllers;

use App\Models\Draw;
use App\Utility\Request;

class Participants extends Controller
{
	public function index($request): void
	{
		if (!is_object($request)) $drawId = $request['draw-id'] ?? null;
		else $drawId = 0;

		if (!empty($drawId)) {
			$participants = (new \App\Models\Participants())->query("
				SELECT u.*, p.`added` as date
				FROM `participants` p,
					 `users` u
				WHERE p.`user_id` = u.`id`
				AND p.`draw_id` = :drawId
			", [
				'drawId' => $drawId
			], true);
		}
		$this->view('index', [
			'title' => __('participants'),
			'pageTitle' => __('participants'),
			'participants' => $participants ?? [],
			'drawId' => $drawId,
			'draws' => array_map(function ($draw) {
				$draw->title = json_decode($draw->title);
				$draw->description = json_decode($draw->description);
				return $draw;
			}, (new Draw())->getObjects(['active' => 1], 'AND', 'id', 'DESC')),
			'assets' => [
				'css' => 'dataTables.dataTables.min.css',
				'js' => [
					'dataTables.min.js',
					'participants.js'
				]
			]
		]);
	}
}