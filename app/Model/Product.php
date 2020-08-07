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

    public function carts(){
        return $this->hasMany('App\Model\Cart');
    }

    public function order_logs(){
        return $this->hasMany('App\Model\Order_log');
    }

    public function catalogs(){
        return $this->belongsToMany('App\Model\Catalog');
    }
}
