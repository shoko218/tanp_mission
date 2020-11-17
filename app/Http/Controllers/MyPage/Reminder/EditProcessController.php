<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use Illuminate\Http\Request;
use App\Model\Lover;
use Illuminate\Support\Facades\Auth;

class EditProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->lover_id!=null){
            $lover=Lover::find($request->lover_id);
            if($lover==null||$lover->user_id!=Auth::user()->id){
                return back()->with('err_msg','エラーが発生しました。');
            }
        }
        if($request->event_id!=null){
            $event=Event::find($request->event_id);
            if($event==null){
                return back()->with('err_msg','エラーが発生しました。');
            }
            $this->validate($request,Event::$rules);
            Event::find($request->event_id)->fill($request->except('event_id'))->save();
            return redirect('/mypage/reminder/'.$request->event_id)->with('suc_msg','変更しました。')->with('event_id',$request->event_id);
        }else{
            return back()->with('err_msg','エラーが発生しました。');
        }
    }
}
