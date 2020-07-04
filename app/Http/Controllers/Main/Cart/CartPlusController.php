<?php

namespace App\Http\Controllers\Main\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Model\Cart;

class CartPlusController extends Controller
{
    public function __invoke(Request $request)
    {
        $user_id=Auth::user()->id;
        if(Auth::check()){
            $target=Cart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->first();
            $target->update(['count'=>$target->count+1]);
        }else{
            $product_ids=Cookie::get('cart_product_ids');
            $product_ids.=$request->product_id.',';
            Cookie::queue('cart_product_ids', $product_ids,86400);//60*24*60=60日
        }
        return redirect('/cart');
    }
}
