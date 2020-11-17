<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DeleteProcessController extends Controller
{
    public function __invoke(Request $request){
        if($request->event_id!=null){
            $event=Event::find($request->event_id);
            if($event==null||$event->lover->user_id!=Auth::user()->id){
                return back()->with('err_msg','エラーが発生しました。');
            }
        }
        $event->delete();
        return redirect('mypage/reminder')->with('suc_msg','削除しました。');
    }
}
