<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use App\Model\Order_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftHistoryController extends Controller
{
    public function __invoke(Request $request)
    {
        $lover_id=$request->id;
        $name=$request->name;
        $order_logs=Order_log::join('orders','orders.id',"order_id")
        ->select('order_logs.*')
        ->where('orders.lover_id','=',$lover_id)
        ->orderBy('id', 'desc')
        ->paginate(10);
        $param=['order_logs'=>$order_logs,'name'=>$name];
        return view('mypage.lovers.gift_history',$param);
    }
}
