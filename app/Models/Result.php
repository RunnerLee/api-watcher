<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'api_id',
        'faker_id',
        'mission_id',
        'is_successful',
        'is_timeout',
        'time_cost',
        'status_code',
        'response_size',
        'response_headers',
        'response_content',
        'error_message',
    ];

    public function api()
    {
        return $this->belongsTo(Api::class);
    }

    public function faker()
    {
        return $this->belongsTo(Faker::class);
    }

    public function scopeByApiId($query, $appId)
    {
        return $query->where('api_id', $appId);
    }

    public function scopeWithFailed($query)
    {
        return $query->where('is_successful', 'no');
    }
}

