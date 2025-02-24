<?php

namespace App\Models;

class Participants extends Model
{
    protected $table = 'participants';
    protected $fields = [
        'draw_id', 'user_id'
    ];
}