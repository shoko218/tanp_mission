<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }

    public function product(){
        return $this->belongsTo('App\Model\Product');
    }
}
