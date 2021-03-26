<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = ['id','created_at','updated_at'];

    public static $rules = array(
        'lover_id' => ['required','integer'],
        'title' => ['required','string','max:30','text'],
        'scene_id' => ['required','integer','between:1,17'],
        'date' => ['required','datetype','date','future'],
        'is_repeat' => ['required','boolean'],
    );

    public function lover()
    {
        return $this->belongsTo('App\Model\Lover');
    }

    public function scene()
    {
        return $this->belongsTo('App\Model\Scene');
    }
}
