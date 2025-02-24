<?php

namespace App\Api;

use App\Models\User;

class DeterminationWinners
{
    public function execute($drawId, $numberOfWinners): void
    {
        $winners = $this->getWinners($drawId, $numberOfWinners);
        $winning = $this->winnings($drawId, $winners);
        dd($winning);
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
        $randomKeys = array_rand($users, $numberOfWinners);
        $randomUsers = [];
        foreach ($randomKeys as $key) {
            $randomUsers[] = $users[$key];
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
                $winner['referrer_prize'] = round($winner['prize'] * (settings('percentage_referrer') * 0.01), 9);
            } else $winner['referrer_prize'] = 0;
            return $winner;
        }, $winners);
    }
}