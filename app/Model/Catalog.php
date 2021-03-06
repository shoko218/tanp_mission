<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    protected $fillable = ['name', 'email','img_num'];

    public static $rules=array(
        'name'=>['required', 'string', 'max:64'],
        'email'=>['required', 'string', 'max:255'],
        'img_num'=>['required','integer','between:1,16'],
    );

    public function products(){
        return $this->belongsToMany('App\Model\Product');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
