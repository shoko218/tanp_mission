<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\BaseClass;
use App\Model\Order_log;
use Illuminate\Support\Facades\DB;
use App\Model\Lover;

class GetLoverController extends Controller
{
    public function __invoke(Request $request)
    {
        if (session('lover_id')!=null) {
            $lover_id=session('lover_id');
        }else{
            return redirect('/mypage/lovers/top');
        }
        $lover=Lover::find($lover_id);
        if(Order_log::join('orders','orders.id','=','order_id')->select('orders.id')->where('lover_id','=',$lover_id)->first()){
            $products=BaseClass::get_reccomends($lover_id);
        }else{
            $products=null;
        }
        $param=['id'=>$lover_id,'name'=>$lover->last_name.$lover->first_name,'products'=>$products];
        return view('mypage.lovers.lover',$param);
    }
}
