<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Lover;

class Relationship extends Model
{
    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }
}
