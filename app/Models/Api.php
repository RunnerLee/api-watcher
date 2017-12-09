<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{

    public function fakers()
    {
        return $this->hasMany(Faker::class);
    }

    public function group()
    {
        return $this->belongsTo(ApiGroup::class);
    }
}
