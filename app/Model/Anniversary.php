<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Anniversary extends Model
{
    protected $guarded =array('id');

    public static $rules=array(
        'lover_id'=>['required','integer'],
        'title'=>['required','string','max:30'],
        'scene_id'=>['required','integer'],
        'date'=>['required','date'],
    );
}
