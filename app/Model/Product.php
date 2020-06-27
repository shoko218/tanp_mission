<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function orders(){
        return $this->hasMany('App\Model\Order');
    }

    public function genre(){
        return $this->belongsTo('App\Model\Genre');
    }
}
