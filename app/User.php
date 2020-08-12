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

    public function lovers(){
        return $this->hasMany('App\Model\Lover');
    }

    public function catalogs(){
        return $this->hasMany('App\Model\Catalog');
    }
}
