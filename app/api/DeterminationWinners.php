<?php

namespace App\Api;

use App\Models\User;
use App\Models\Winner;
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
		}

		$drawCompleted = @json_decode(Redis::get('drawCompleted'), true) ?? [];
		$drawCompleted[$drawId] = $winning;
		Redis::set('drawCompleted', json_encode($drawCompleted));
		echo json_encode($winning);
	}

	public function getWinners($drawId, $numberOfWinners): array
	{
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