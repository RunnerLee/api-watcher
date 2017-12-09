<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleRule extends Model
{

    public function apiGroup()
    {
        return $this->belongsTo(ApiGroup::class);
    }

}
