<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventDeleteProcessController extends Controller
{
    public function __invoke(Request $request){
        Event::find($request->event_id)->delete();
        return redirect('mypage/reminder/top')->with('suc_msg','削除しました。');;
    }
}
