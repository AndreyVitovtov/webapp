<?php

namespace App\Models;

class Winner extends Model
{
    protected $table = 'winners';
    protected $fields = [
        'draw_id', 'user_id', 'prize', 'prize_referrer', 'coefficient', 'percentage_referrer', 'paid_out'
    ];
}