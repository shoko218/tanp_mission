<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
