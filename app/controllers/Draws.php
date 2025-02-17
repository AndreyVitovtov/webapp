<?php

namespace App\Controllers;

use App\Models\Draw;
use App\Utility\Request;

class Draws extends Controller
{
    public function all(): void
    {
        $draws = (new Draw())->getObjects();
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
        $this->view('add', [
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
        $active = ($request->active ? 1 : 0);
        if ($active) $this->updateActive();
        $draw = new Draw();
        $draw->title = json_encode($request->title);
        $draw->description = json_encode($request->description);
        $draw->date = $request->date;
        $draw->active = $active;
        $draw->prize = $request->prize;
        $draw->insert();
        redirect('/draws/all', [
            'message' => __('draw added')
        ]);
    }

    public function edit($id): void
    {
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
        $active = ($request->active ? 1 : 0);
        if ($active) $this->updateActive();
        $draw = new Draw();
        $draw->find($request->id);
        $draw->title = json_encode($request->title);
        $draw->description = json_encode($request->description);
        $draw->date = $request->date;
        $draw->active = $active;
        $draw->prize = $request->prize;
        $draw->update();
        redirect('/draws/all', [
            'message' => __('draw edited')
        ]);
    }

    public function delete($id): void
    {
        (new Draw())->delete($id);
        redirect('/draws/all', [
            'message' => __('draw deleted')
        ]);

    }
}