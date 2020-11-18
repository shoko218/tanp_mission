<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use App\Model\Event;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function __invoke($event_id)//イベントの詳細を取得
    {
        $event=Event::find($event_id);//イベントまでの残り日数計算
        $to=new DateTime($event->date);
        $from=new DateTime();
        $from=date_create('today');
        $diff=$from->diff($to);

        $url=config('constant.domain')."/result?_token=yQ9lAaaNc7yjHmAfnvwM6TB0pQaGoO4wuN9ps21J&target_scene_id=".$event->scene_id."&target_genre_id=".$event->genre_id."&target_relationship_id=".$event->lover->relationship_id."&target_gender=".$event->lover->gender."&target_generation_id=".(intval(floor((intval(date ( 'Ymd', time ()))-intval(str_replace('-', '', $event->lover->birthday)))/10000)/10)+1)."&sort_by=0&keyword=";
        $param=['event'=>$event,'diff'=>$diff,'url'=>$url];
        return view('mypage.reminder.detail',$param);
    }
}
