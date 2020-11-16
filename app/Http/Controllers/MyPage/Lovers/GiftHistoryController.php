<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use App\Model\Lover;
use App\Model\Order_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftHistoryController extends Controller
{
    public function __invoke($lover_id)//大切な人に今まであげたもののリスト
    {
        $lover=Lover::find($lover_id);
        $order_logs=Order_log::join('orders','orders.id',"order_id")
        ->select('order_logs.*')
        ->where('orders.lover_id','=',$lover_id)
        ->orderBy('id', 'desc')
        ->paginate(12);
        $param=['order_logs'=>$order_logs,'name'=>$lover->last_name.$lover->first_name];
        return view('mypage.lovers.gift_history',$param);
    }
}
