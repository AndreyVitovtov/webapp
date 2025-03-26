<?php

namespace App\Controllers;

use App\Utility\Request;

class Withdrawals extends Controller
{
	public function new(): void
	{
		$this->auth();
		$newWithdrawals = array_map(function ($withdrawal) {
			$withdrawal->user = (new \App\Models\User($withdrawal->user_id))->getOneObject();
			return $withdrawal;
		}, (new \App\Models\Withdrawals())->getObjects(['status' => 'NEW'], 'AND', 'id', 'DESC'));

		$this->view('new', [
			'title' => __('new withdrawals'),
			'pageTitle' => __('new withdrawals'),
			'newWithdrawals' => $newWithdrawals,
			'assets' => [
				'js' => [
					'withdrawals.js',
					'dataTables.min.js'
				],
				'css' => [
					'dataTables.dataTables.min.css'
				]
			]
		]);
	}

	public function archive(): void
	{
		$this->auth();
		$withdrawals = array_map(function ($withdrawal) {
			$withdrawal = (new \App\Models\Withdrawals($withdrawal));
			$withdrawal->user = (new \App\Models\User($withdrawal->user_id))->getOneObject();
			return $withdrawal;
		}, (new \App\Models\Withdrawals())->query("
			SELECT * 
			FROM `withdrawals` 
			WHERE `status` != 'NEW' 
			ORDER BY id DESC
		", [], true));
		$this->view('archive', [
			'title' => __('withdrawals'),
			'pageTitle' => __('withdrawals'),
			'withdrawals' => $withdrawals,
			'assets' => [
				'js' => [
					'withdrawals.js',
					'dataTables.min.js'
				],
				'css' => [
					'dataTables.dataTables.min.css'
				]
			]
		]);
	}

	public function update(Request $request): void
	{
		$withdrawals = (new \App\Models\Withdrawals())->find($request->id);
		$withdrawals->status = $request->status;
		$withdrawals->update();
		echo json_encode([
			'status' => true,
			'message' => __('changes saved')
		]);
	}

	public function delete(Request $request): void
	{
		$this->auth();
		(new \App\Models\Withdrawals())->delete($request->id);
		redirect('/withdrawals/archive', [
			'message' => __('withdrawal deleted')
		]);
	}
}