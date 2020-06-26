<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function __invoke(Request $request)
    {
        $event=Event::find($request->id);
        $param=['event'=>$event];
        return view('mypage.reminder.reminder_detail',$param);
    }
}
