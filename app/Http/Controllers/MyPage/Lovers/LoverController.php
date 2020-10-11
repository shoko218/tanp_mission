<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\BaseClass;
use App\Model\Lover;
use App\Model\Order_log;
use Illuminate\Support\Facades\DB;

class LoverController extends Controller
{
    public function __invoke(Request $request)
    {
        $lover_id=$request->id;
        if(Order_log::join('orders','orders.id','=','order_id')->select('orders.id')->where('lover_id','=',$lover_id)->first()){
            $products=BaseClass::get_reccomends($lover_id);
        }else{
            $products=null;
        }
        $lover=Lover::find($lover_id);
        $param=['id'=>$lover_id,'name'=>$request->name,'products'=>$products,'img_path'=>$lover->img_path];
        return view('mypage.lovers.lover',$param);
    }
}
