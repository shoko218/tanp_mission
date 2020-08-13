<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\BaseClass;
use App\Model\Order_log;
use Illuminate\Support\Facades\DB;

class LoverController extends Controller
{
    public function __invoke(Request $request)
    {
        if(Order_log::join('orders','orders.id','=','order_id')->select('orders.id')->where('lover_id','=',$request->id)->first()){
            $products=BaseClass::get_reccomends($request->id);
        }else{
            $products=null;
        }
        $param=['id'=>$request->id,'name'=>$request->name,'products'=>$products];
        return view('mypage.lovers.lover',$param);
    }
}
