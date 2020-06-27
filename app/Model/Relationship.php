<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Relationship extends Model
{
    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }
}
