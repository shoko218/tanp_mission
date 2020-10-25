<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use Illuminate\Http\Request;

class EditProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,Event::$rules);
        Event::find($request->event_id)->fill($request->except('event_id'))->save();
        return redirect('/mypage/reminder/'.$request->event_id)->with('suc_msg','変更しました。')->with('event_id',$request->event_id);
    }
}
