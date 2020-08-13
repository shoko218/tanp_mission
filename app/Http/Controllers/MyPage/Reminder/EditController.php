<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use App\Model\Lover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Scene;

class EditController extends Controller
{
    public function __invoke(Request $request){
        $user_id=Auth::user()->id;
        $lovers = Lover::select('last_name','first_name','lovers.id')
        ->where('user_id',$user_id)
        ->get();
        $scenes = Scene::all();
        $event=Event::find($request->event_id);
        $param=['lovers'=>$lovers,'scenes'=>$scenes,'event'=>$event];
        return view('mypage.reminder.edit',$param);
    }
}
