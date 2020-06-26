<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Event;

class TopController extends Controller
{
    public function __invoke()
    {
        $user_id=Auth::user()->id;
        $events=Event::join('lovers', 'lover_id', '=', 'lovers.id')
        ->join('users','user_id','=','users.id')
        ->where('lovers.user_id',$user_id)
        ->get();
        $param=['events'=>$events];
        return view('mypage.reminder.top',$param);
    }
}
