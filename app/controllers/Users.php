<?php

namespace App\Controllers;

use App\Models\Coefficients;
use App\Models\User;
use App\Utility\Request;
use App\Utility\TelegramBot;

class Users extends Controller
{
    public function index(): void
    {
        $referrals = (new User)->query("
            SELECT `referrer_id` AS id, COUNT(*) AS referrals
            FROM `users`
            WHERE `referrer_id` IS NOT NULL
            GROUP BY `referrer_id`
            ORDER BY `referrals` DESC
        ", [], true);
        $referrals = array_combine(array_column($referrals, 'id'), array_column($referrals, 'referrals'));
        $users = (new User())->getObjects();
        $users = array_map(function ($user) use ($referrals) {
            $user->referrals = $referrals[$user->id] ?? 0;
            return $user;
        }, $users);

        $this->auth()->view('index', [
            'title' => __('users'),
            'pageTitle' => __('users'),
            'users' => $users,
            'assets' => [
                'js' => [
                    'dataTables.min.js',
                    'users.js'
                ],
                'css' => [
                    'users.css',
                    'dataTables.dataTables.min.css'
                ]
            ]
        ]);
    }

    public function details($id): void
    {
        $this->auth();
        $user = (new User())->find($id);
        $referrer = $user->referrer_id;
        if (!empty($referrer)) {
            $referrer = (new User())->find($referrer);
            $user->referrer = [
                'id' => $referrer->id,
                'username' => $referrer->username,
            ];
        }
        $coefficients = (new Coefficients())->getOneObject(['user_id' => $user->id]);
        $coefficientAdmin = $coefficients->coefficient_admin ?? '';
        $coefficient = $coefficients->coefficient;
        $this->view('details', [
            'title' => __('user details') . ' ' . $user->username,
            'pageTitle' => __('user details') . ' ' . $user->username,
            'user' => $user,
            'assets' => [
                'css' => 'users.css'
            ],
            'coefficientAdmin' => $coefficientAdmin,
            'coefficient' => $coefficient
        ]);
    }

    public function addCoefficient(Request $request): void
    {
        $this->auth();
        $coefficient = $request->coefficient;
        if (empty($coefficient)) $coefficient = 0;
        $coefficients = (new Coefficients())->getOneObject(['user_id' => $request->id]);
        $coefficients->coefficient_admin = $coefficient;
        $coefficients->update();
        redirect('/users/details/' . $request->id, [
            'message' => __('coefficient updated')
        ]);
    }

    public function sendMessage(Request $request): void
    {
        $this->auth();
        $user = (new User)->find($request->id);
        $telegram = new TelegramBot(TELEGRAM_TOKEN);
        $telegram->sendMessage($user->chat_id, $request->text);
        redirect('/users/details/' . $request->id, [
            'message' => __('message sent')
        ]);
    }
}