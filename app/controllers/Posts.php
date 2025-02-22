<?php

namespace App\Controllers;

class Posts extends Controller
{
    public function index()
    {
        $this->view('index', [
            'title' => __('posts'),
            'pageTitle' => __('posts')
        ]);
    }
}