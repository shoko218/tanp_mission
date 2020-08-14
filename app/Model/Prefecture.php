<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    public function user()
    {
        return $this->hasMany('App\User');
    }
}
