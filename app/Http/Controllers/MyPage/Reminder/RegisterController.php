<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Scene;
use App\Model\Lover;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $user_id=Auth::user()->id;
        $lovers = Lover::select('last_name','first_name','lovers.id')
        ->where('user_id',$user_id)
        ->get();
        $scenes = Scene::all();
        $param=['lovers'=>$lovers,'scenes'=>$scenes];
        return view('mypage.reminder.register',$param);
    }
}
