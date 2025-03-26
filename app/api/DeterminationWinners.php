<?php

namespace App\Api;

use App\Models\Balance;
use App\Models\User;
use App\Models\Winner;
use App\Models\WinnersDraw;
use App\Utility\Redis;

class DeterminationWinners
{
	public function execute($drawId, $numberOfWinners): void
	{
		$winners = $this->getWinners($drawId, $numberOfWinners);
		$winning = $this->winnings($drawId, $winners);

		foreach ($winning as $w) {
			$winner = (new Winner());
			$winner->draw_id = $drawId;
			$winner->user_id = $w['id'];
			$winner->prize = $w['prize'];
			$winner->prize_referrer = $w['referrer_prize'] ?? 0;
			$winner->coefficient = $w['coefficient'];
			$winner->percentage_referrer = $w['percentage_referrer'] ?? 0;
			$winner->insert();

			// Update winner balance
			$balance = (new Balance())->getOneObject(['user_id' => $w['id']]);
			if (!empty($balance)) {
				$balance->balance += ($w['prize'] ?? 0);
				$balance->update();
			} else {
				$balance = new Balance();
				$balance->user_id = $w['id'];
				$balance->balance = ($w['prize'] ?? 0);
				$balance->insert();
			}

			// Update referrer balance
			if (!empty($w['referrer_prize'] ?? 0)) {
				$balance = (new Balance())->getOneObject(['user_id' => $w['referrer_id']]);
				if (!empty($balance)) {
					$balance->balance += ($w['referrer_prize'] ?? 0);
					$balance->update();
				} else {
					$balance = new Balance();
					$balance->user_id = $w['referrer_id'];
					$balance->balance = ($w['prize'] ?? 0);
					$balance->insert();
				}
			}
		}

		$drawCompleted = @json_decode(Redis::get('drawCompleted'), true) ?? [];
		$drawCompleted[$drawId] = $winning;
		Redis::set('drawCompleted', json_encode($drawCompleted));
		echo json_encode($winning);
	}

	public function getWinners($drawId, $numberOfWinners): array
	{
		$winnersDraw = (new WinnersDraw())->query("
			SELECT u.*, IF(c.`coefficient_admin` > 0, c.`coefficient_admin`, c.`coefficient`) AS coefficient
			FROM `winners_draw` w,
			     `users` u,
			     `coefficients` c
			WHERE w.`user_id` = u.`id`
			AND u.`id` = c.`user_id`
			AND w.`draw_id` = :draw_id
		", [
			'draw_id' => $drawId
		], true);
		if (!empty($winnersDraw)) return $winnersDraw;

		$users = (new \App\Models\User())->query("
            SELECT u.*, IF(c.`coefficient_admin` > 0, c.`coefficient_admin`, c.`coefficient`) AS coefficient
            FROM `users` u,
                 `participants` p,
                 `coefficients` c
            WHERE u.`id` = p.`user_id`
            AND p.`draw_id` = :drawId
            AND u.`id` = c.`user_id`
            AND u.`active` = 1
        ", [
			'drawId' => $drawId
		], true);
		if (empty($users)) return [];
		$users = array_combine(array_column($users, 'id'), $users);
		shuffle($users);
		$randomKeys = array_rand($users, min([count($users), $numberOfWinners]));
		$randomKeys = (is_array($randomKeys) ? $randomKeys : [0]);
		$randomUsers = [];
		foreach ($randomKeys as $key) {
			if (isset($users[$key])) $randomUsers[] = $users[$key];
		}
		return $randomUsers;
	}

	private function winnings($drawId, array $winners): array
	{
		$draw = (new \App\Models\Draw())->find($drawId);
		$prize = $draw->prize;
		$sumCoefficients = array_sum(array_column($winners, 'coefficient'));
		return array_map(function ($winner) use ($prize, $sumCoefficients) {
			$winner['prize'] = round(($winner['coefficient'] / $sumCoefficients) * $prize, 9);
			if (!empty($winner['referrer_id'])) {
				$percentageReferrer = settings('percentage_referrer');
				$winner['referrer_prize'] = round($winner['prize'] * ($percentageReferrer * 0.01), 9);
				$winner['percentage_referrer'] = $percentageReferrer;
			} else $winner['referrer_prize'] = 0;
			return $winner;
		}, $winners);
	}
}