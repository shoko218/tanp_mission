<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded =array('id');

    public static $rules=array(
        'lover_id'=>['required','integer'],
        'title'=>['required','string','max:30'],
        'scene_id'=>['required','integer'],
        'date'=>['required','date'],
    );

    public function lover(){
        return $this->belongsTo('App\Model\Lover');
    }
    public function scene(){
        return $this->belongsTo('App\Model\Scene');
    }
}
