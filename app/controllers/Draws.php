<?php

namespace App\Controllers;

use App\Api\DeterminationWinners;
use App\Models\Channel;
use App\Models\Draw;
use App\Utility\Request;

class Draws extends Controller
{
    public function all(): void
    {
        $this->auth();
        $draws = (new Draw())->getObjects([], 'AND', 'id', 'DESC');
        $this->view('all', [
            'title' => __('draws'),
            'pageTitle' => __('draws'),
            'draws' => array_map(function ($draw) {
                $draw->title = json_decode($draw->title);
                $draw->description = json_decode($draw->description);
                return $draw;
            }, $draws)
        ]);
    }

    public function add(): void
    {
        $this->auth()->view('add', [
            'title' => __('add draw'),
            'pageTitle' => __('add draw')
        ]);
    }

    private function updateActive(): void
    {
        $draw = new Draw();
        $draw->query('UPDATE draws SET active = 0');
    }

    public function addSave(Request $request): void
    {
        $this->auth();
        $active = ($request->active ? 1 : 0);
        $hash = $this->generateHash();
//        if ($active) $this->updateActive();
        $draw = new Draw();
        $draw->title = json_encode($request->title);
        $draw->description = json_encode($request->description);
        $draw->date = $request->date;
        $draw->active = $active;
        $draw->hash = $hash;
        $draw->prize = $request->prize;
        $draw->winners = $request->winners;
        $draw->insert();
        redirect('/draws/all', [
            'message' => __('draw added')
        ]);
    }

    public function edit($id): void
    {
        $this->auth();
        $draw = new Draw();
        $draw = $draw->find($id);
        $draw->title = json_decode($draw->title);
        $draw->description = json_decode($draw->description);
        $this->view('edit', [
            'title' => __('edit draw'),
            'pageTitle' => __('edit draw'),
            'draw' => $draw
        ]);
    }

    public function editSave(Request $request): void
    {
        $this->auth();
        $active = ($request->active ? 1 : 0);
//        if ($active) $this->updateActive();
        $draw = new Draw();
        $draw->find($request->id);
        $draw->title = json_encode($request->title);
        $draw->description = json_encode($request->description);
        $draw->date = $request->date;
        $draw->active = $active;
        $draw->prize = $request->prize;
        $draw->winners = $request->winners;
        $draw->update();
        redirect('/draws/all', [
            'message' => __('draw edited')
        ]);
    }

    public function delete(Request $request): void
    {
        $this->auth();

        (new Channel)->query('DELETE FROM `channels` WHERE draw_id = :drawId', [
            'drawId' => $request->id
        ]);

        (new Draw())->delete($request->id);
        redirect('/draws/all', [
            'message' => __('draw deleted')
        ]);

    }

    private function generateHash($length = 12): string
    {
        return substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes($length))), 0, $length);
    }

    public function execute()
    {
        (new DeterminationWinners)->execute($numberOfWinners = 2);
    }
}