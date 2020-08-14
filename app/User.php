<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name','first_name','last_name_furigana','first_name_furigana','email', 'password','birthday','gender','postal_code','prefecture_id','address','telephone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $dates = ['birthday'];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static $except_mail_pass_rules=array(
        'last_name'=>['required', 'string', 'max:32'],
        'first_name'=>['required', 'string', 'max:32'],
        'last_name_furigana'=>['required', 'string', 'max:64'],
        'first_name_furigana'=>['required', 'string', 'max:64'],
        // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        'birthday'=>['required','date'],
        'gender'=>['required','integer'],
        'postal_code'=>['nullable','string','digits:7'],
        'prefecture_id'=>['nullable','integer'],
        'address'=>['nullable','string', 'max:200'],
        'telephone'=>['nullable','string', 'max:21'],
    );

    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }

    public function catalogs(){
        return $this->hasMany('App\Model\Catalog');
    }

    public function prefecture(){
        return $this->belongsTo('App\Model\Prefecture');
    }
}
