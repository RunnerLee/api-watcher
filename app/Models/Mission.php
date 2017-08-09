<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{

    protected $fillable = [
        'api_group_id',
        'start_time',
        'finish_time',
        'result_count',
        'unsuccessful_result_count',
        'is_solved',
    ];


}
