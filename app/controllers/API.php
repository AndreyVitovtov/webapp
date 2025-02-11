<?php

namespace App\Controllers;

use app\api\RequestHandler;

class API extends Controller
{
    private RequestHandler $handler;

    public function __construct()
    {
        $this->handler = new RequestHandler();
    }


    public function getItems()
    {
        if($this->handler->GET())
        {
            return $this->handler->GET();
        }
        return null;
    }
}