<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Event;
use DateTime;

class GetDetailController extends Controller
{
    public function __invoke(Request $request)
    {
        if(session('event_id')!=null){
            $event=Event::find(session('event_id'));
            $to=new DateTime($event->date);
            $from=new DateTime();
            $diff=$from->diff($to);
            $url="http://tanp_mission.jp/result?_token=yQ9lAaaNc7yjHmAfnvwM6TB0pQaGoO4wuN9ps21J&target_scene_id=".$event->scene_id."&target_genre_id=".$event->genre_id."&target_relationship_id=".$event->lover->relationship_id."&target_gender=".$event->lover->gender."&target_generation_id=".(intval(floor((intval(date ( 'Ymd', time ()))-intval(str_replace('-', '', $event->lover->birthday)))/10000)/10)+1)."&sort_by=0&keyword=";
            $param=['event'=>$event,'diff'=>$diff,'url'=>$url];
            return view('mypage.reminder.reminder_detail',$param);
        }else{
            return redirect('/mypage/reminder/top');
        }
    }
}