<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use App\Model\Lover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterProcessController extends Controller
{
    public function __invoke(Request $request)//イベントを登録
    {
        $this->validate($request, Event::$rules);
        $event = Event::create(['lover_id' => $request->lover_id,'title' => $request->title,'scene_id' => $request->scene_id,'date' => $request->date,'is_repeat' => $request->is_repeat]);
        return redirect('/mypage/reminder')->with('suc_msg', '登録しました。');
    }
}
