<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'api_id',
        'faker_id',
        'is_successful',
        'is_timeout',
        'time_cost',
        'status_code',
        'response_size',
        'response_headers',
        'response_content',
    ];
}
