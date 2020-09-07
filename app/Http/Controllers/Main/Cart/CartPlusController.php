<?php

namespace App\Http\Controllers\Main\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Model\Cart;
use App\Library\BaseClass;

class CartPlusController extends Controller
{
    public function __invoke(Request $request)
    {
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $target=Cart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->first();
            if(!empty($target)){
                $target->update(['count'=>$target->count+1]);
            }else{
                Cart::create(['user_id'=>$user_id,'product_id'=>$request->product_id,'count']);
            }

            $cart_goods=BaseClass::getProductsFromDB();
            if(!$cart_goods->isEmpty()){
                $sum_price=BaseClass::calcPriceInTaxFromDB($cart_goods);
            }else{
                $cart_goods=[];
                $sum_price=0;
            }
            $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>[],'product_count'=>[]];
            return $param;
        }else{
            $cart_product_ids=Cookie::get('cart_product_ids');
            $cart_product_ids.=$request->product_id.',';
            Cookie::queue('cart_product_ids', $cart_product_ids,86400);
            if($cart_product_ids!=null){
                list($products,$product_count)=BaseClass::getProductsFromCookie($cart_product_ids);
                $sum_price=BaseClass::calcPriceInTaxFromCookie($products,$product_count);
            }else{
                $products=null;
                $product_count=0;
                $sum_price=0;
            }
            $param=['products'=>$products,'sum_price'=>$sum_price,'product_count'=>$product_count,'cart_goods'=>0];
            return $param;
        }
    }
}
