<?php

namespace App\Models;

class Winner extends Model
{
    protected $table = 'winners';
    protected $fields = [
        'draw_id', 'user_id', 'prize', 'paid_out'
    ];
}