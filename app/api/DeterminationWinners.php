<?php

namespace App\Api;

use App\Models\User;

class DeterminationWinners
{
    public function execute(): void
    {
        dd($this->getWinners(2));
    }

    public function getWinners($numberOfWinners): array
    {
        $users = (new \App\Models\User())->get(['active' => 1]);
        $users = array_combine(array_column($users, 'id'), $users);
        shuffle($users);
        $randomKeys = array_rand($users, $numberOfWinners);
        $randomUsers = [];
        foreach ($randomKeys as $key) {
            $randomUsers[] = $users[$key];
        }
        return array_map(function ($user) {
            return (new User($user));
        }, $randomUsers);
    }
}