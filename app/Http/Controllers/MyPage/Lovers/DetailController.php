<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\BaseClass;
use App\Model\Lover;
use App\Model\Order_log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function __invoke($lover_id)//大切な人の詳細表示
    {
        $lover=Lover::find($lover_id);
        if(Order_log::join('orders','orders.id','=','order_id')->select('orders.id')->where('lover_id','=',$lover_id)->first()){
            $reccomend_products=BaseClass::get_reccomends($lover_id);//その人に買ったものに合わせて商品をレコメンド
        }else{
            $reccomend_products=null;
        }
        $param=['id'=>$lover_id,'name'=>$lover->last_name.$lover->first_name,'reccomend_products'=>$reccomend_products,'img_path'=>$lover->img_path];
        return view('mypage.lovers.detail',$param);
    }
}
