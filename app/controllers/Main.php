<?php

namespace App\Controllers;

use App\Models\User;

class Main extends Controller
{
    public function __construct()
    {
		parent::__construct();
//		$this->forbid = [
//			'guest' => 'ALL'
//		];
    }

    public function index(): void
    {
        $this->auth()->view('dashboard', [
            'title' => __('dashboard'),
            'pageTitle' => __('dashboard'),
            'assets' => [
                'js' => [
                    'chart.umd.min.js',
                    'dashboardCharts.js'
                ]
            ],
            'numberRegistrations' => $this->getRegistrations(),
            'activeUsers' => $this->getActiveUsers()
        ]);
    }

    private function getRegistrations($countDays = 10): array
    {
        $date = date('Y-m-d', strtotime('-' . $countDays . ' days'));
        $numberRegistrationsByDates = (new User())->query("
            SELECT DATE(`added`) as date, COUNT(*) as number
            FROM `users`
            WHERE `added` >= :date
            GROUP BY date
        ", [
            'date' => $date
        ], true);
        $numberRegistrationsByDates = array_combine(array_column($numberRegistrationsByDates, 'date'), array_column($numberRegistrationsByDates, 'number'));
        $numberRegistrations = [];
        for ($i = 1; $i <= $countDays; $i++) {
            $newDate = date('Y-m-d', strtotime('+' . $i . ' days', strtotime($date)));
            $numberRegistrations[date('d.m', strtotime($newDate))] = $numberRegistrationsByDates[$newDate] ?? 0;
        }
        return $numberRegistrations;
    }

    private function getActiveUsers(): array
    {
        $users = (new User())->query("
            SELECT IF(`active`, 'active users', 'no active users') as type, COUNT(*) as number
            FROM `users`
            GROUP BY type
        ", [], true);

        $users = array_combine(array_column($users, 'type'), array_column($users, 'number'));
        return [
            __('active users') => $users['active users'] ?? 0,
            __('no active users') => $users['no active users'] ?? 0
        ];
    }
}