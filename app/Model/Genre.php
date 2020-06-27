<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public function products(){
        return $this->hasMany('App\Model\Product');
    }
}
