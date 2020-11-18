<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use App\Model\Order_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function __invoke()//注文履歴を表示
    {
        $user_id=Auth::user()->id;
        $order_logs=Order_log::join('orders','orders.id',"order_id")->select('order_logs.*')->where('user_id','=',$user_id)->orderBy('id', 'desc')->paginate(12);
        $param=['order_logs'=>$order_logs];
        return view('mypage.order_history',$param);
    }
}
