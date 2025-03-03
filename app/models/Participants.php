<?php

namespace App\Models;

/**
 * @property false|mixed|string|null $user_id
 * @property false|int|mixed|string|null $draw_id
 */
class Participants extends Model
{
    protected $table = 'participants';
    protected $fields = [
        'draw_id', 'user_id'
    ];
}