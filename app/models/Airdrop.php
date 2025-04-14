<?php

namespace App\Models;

/**
 * @property mixed|null $title
 * @property mixed|null $date
 * @property mixed|null $total
 * @property mixed|null $per_user
 * @property mixed|null $max_winners
 * @property mixed|null $channel_draw
 * @property mixed|null $channel_project_draw
 * @property mixed|null $group_project_draw
 * @property mixed|null $description
 * @property int|mixed|null $active
 */
class Airdrop extends Model
{
	protected $table = 'airdrops';
	protected $fields = [
		'id', 'title', 'logo', 'date', 'total', 'per_user', 'max_winners', 'channel_draw', 'channel_project_draw', 'group_project_draw', 'description', 'status', 'active'
	];
}