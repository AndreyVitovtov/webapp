<?php

namespace App\Controllers;

use App\Models\Draw;
use App\Models\Winner;
use App\Utility\Request;

class Winners extends Controller
{
    public function index(Request $request): void
    {
        $this->showWinners($request->get('drawId'));
    }

    public function draw($id)
    {
        $this->showWinners($id);
    }

    private function showWinners($drawId = null): void
    {
        if (is_object($drawId)) (new Errors())->error404();
        if (!empty($drawId)) {
            $winners = (new Winner())->query("
                SELECT u.`id` AS userId, 
                       u.`username` AS username, 
                       u.`first_name` AS userFirstName, 
                       u.`last_name` AS userLastName, 
                       u.`referrer_id`, 
                       r.`id` AS referrerId, 
                       r.`username` AS referrerUsername, 
                       r.`first_name` AS referrerFirstName, 
                       r.`last_name` AS referrerLastName, 
                       w.`prize`,
                       w.`prize_referrer`,
                       w.`coefficient`,
                       w.percentage_referrer,
                       w.`added`,
                       w.`updated`,
                       w.`paid_out`
                FROM `winners` w, 
                     `users` u 
                LEFT JOIN `users` r ON r.`id` = u.`referrer_id`
                WHERE u.`id` = w.`user_id`
                AND `draw_id` = :drawId
            ", [
                'drawId' => $drawId
            ], true);
        }
        $draws = (new Draw())->query("
            SELECT *
            FROM `draws`
            WHERE `status` IN ('COMPLETED', 'PAYOUT')
            ORDER BY `id` DESC
        ", [], true);
        $this->view('index', [
            'title' => __('winners'),
            'pageTitle' => __('winners'),
            'drawId' => $drawId,
            'winners' => $winners ?? [],
            'draws' => array_map(function ($draw) {
                $draw['title'] = json_decode($draw['title']);
                $draw['description'] = json_decode($draw['description']);
                return (new Draw($draw));
            }, $draws),
            'assets' => [
                'js' => [
                    'winners.js',
//                    'dataTables.min.js'
                ],
//                'css' => [
//                    'dataTables.dataTables.min.css'
//                ]
            ]
        ]);
    }
}