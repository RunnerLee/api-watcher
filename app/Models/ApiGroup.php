<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiGroup extends Model
{

    public function apis()
    {
        return $this->hasMany(Api::class, 'group_id');
    }

}
