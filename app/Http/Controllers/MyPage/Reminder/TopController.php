<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Event;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    public function __invoke()
    {
        $user_id=Auth::user()->id;
        $events=Event::join('lovers', 'lover_id', '=', 'lovers.id')
        ->where('lovers.user_id',$user_id)
        ->select(DB::raw('events.*'))
        ->get();
        $param=['events'=>$events];
        return view('mypage.reminder.top',$param);
    }
}
