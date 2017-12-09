<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faker extends Model
{

    public function api()
    {
        return $this->belongsTo(Api::class);
    }

}
