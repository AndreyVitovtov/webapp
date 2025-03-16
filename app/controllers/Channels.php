<?php

namespace App\Controllers;

use App\Models\Channel;
use App\Models\Draw;
use App\Utility\Request;

class Channels extends Controller
{
    public function add(): void
    {
        $draws = (new Draw)->getObjects([], 'AND', 'id', 'DESC');
        $this->auth()->view('add', [
            'title' => __('add channel'),
            'pageTitle' => __('add channel'),
            'draws' => array_map(function ($draw) {
                $draw->title = json_decode($draw->title);
                $draw->description = json_decode($draw->description);
                return $draw;
            }, $draws)
        ]);
    }

    public function all($params): void
    {
        $this->auth();
        if (!is_object($params) && !empty($params['draw-id'])) {
            $where = ['draw_id' => $params['draw-id']];
            $drawId = $params['draw-id'];
        }
        $draws = (new Draw)->get();
        $draws = array_map(function ($draw) {
            $draw['title'] = json_decode($draw['title'], true);
            $draw['description'] = json_decode($draw['description'], true);
            return $draw;
        }, $draws);
        $draws = array_combine(array_column($draws, 'id'), $draws);
        $this->view('all', [
            'title' => __('channels'),
            'pageTitle' => __('channels'),
            'channels' => (new Channel)->getObjects($where ?? []),
            'draws' => $draws,
            'drawId' => $drawId ?? null
        ]);
    }

    public function addSave(Request $request): void
    {
        $this->auth();
        $channel = new Channel();
        $channel->title = $request->title;
        $channel->url = $request->url;
        $channel->chat_id = trim($request->chat_id);
        $channel->language = $request->language;
        $channel->draw_id = $request->draw;
        $channel->type = $request->type;
        $channel->insert();
        redirect('/channels/all', [
            'message' => __('channel added')
        ]);
    }

    public function edit($id): void
    {
        $this->auth();
        $draws = (new Draw)->getObjects();
        $this->view('edit', [
            'title' => __('edit channel'),
            'pageTitle' => __('edit channel'),
            'channel' => (new Channel)->find($id),
            'draws' => array_map(function ($draw) {
                $draw->title = json_decode($draw->title);
                $draw->description = json_decode($draw->description);
                return $draw;
            }, $draws)
        ]);
    }

    public function editSave(Request $request): void
    {
        $this->auth();
        $channel = new Channel();
        $channel->find($request->id);
        $channel->title = $request->title;
        $channel->url = $request->url;
        $channel->chat_id = trim($request->chat_id);
        $channel->language = $request->language;
        $channel->draw_id = $request->draw;
        $channel->type = $request->type;
        $channel->update();
        redirect('/channels/all', [
            'message' => __('channel edited')
        ]);
    }

    public function delete(Request $request): void
    {
        $this->auth();
        $channel = new Channel();
        $channel->delete($request->id);
        redirect('/channels/all', [
            'message' => __('channel deleted')
        ]);
    }
}