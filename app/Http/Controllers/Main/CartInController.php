<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Model\Cart;

class CartInController extends Controller
{
    public function __invoke(Request $request)
    {
        if(Auth::check()){
            $cart=Cart::create(['user_id'=>$request->user_id,'product_id'=>$request->product_id]);
        }else{
            $product_ids=Cookie::get('cart_product_ids');
            $product_ids.=$request->product_id.',';
            Cookie::queue('cart_product_ids', $product_ids,86400);//60*24*60=60日
        }
        return redirect('/cart');
    }
}
