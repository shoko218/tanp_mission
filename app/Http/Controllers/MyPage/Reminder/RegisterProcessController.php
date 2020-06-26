<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use Illuminate\Http\Request;

class RegisterProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,Event::$rules);
        $event = Event::create(['lover_id'=>$request->lover_id,'title'=>$request->title,'scene_id'=>$request->scene_id,'date'=>$request->date]);
        return redirect('/mypage/reminder/top');
    }
}

