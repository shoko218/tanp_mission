<?php

namespace App\Http\Controllers\Main\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Library\BaseClass;

class CartMinusController extends Controller
{
    public function __invoke(Request $request)
    {
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $target=Cart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->first();
            if($target->count===1){
                $target->delete();
            }
            $target->update(['count'=>$target->count-1]);

            $cart_goods=BaseClass::getProductsFromDB();
            if(!$cart_goods->isEmpty()){
                $sum_price=BaseClass::calcPriceInTaxFromDB($cart_goods);
            }else{
                $cart_goods=[];
                $sum_price=0;
            }
            $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>[],'product_count'=>[]];
        }else{
            $product_ids=explode(',',rtrim(Cookie::get('cart_product_ids'),','));
            for ($i=count($product_ids)-1;$i>-1;$i--) {
                if($request->product_id==$product_ids[$i]){
                    unset( $product_ids[$i]);
                    break;
                }
            }
            $cart_product_ids='';
            if($product_ids!=null){
                foreach ($product_ids as $product_id) {
                    $cart_product_ids=$cart_product_ids.$product_id.',';
                }
            }
            Cookie::queue('cart_product_ids', $cart_product_ids,86400);

            if($cart_product_ids!=null){
                list($products,$product_count)=BaseClass::getProductsFromCookie($cart_product_ids);
                $sum_price=BaseClass::calcPriceInTaxFromCookie($products,$product_count);
            }else{
                $products=[];
                $product_count=0;
                $sum_price=0;
            }
            $param=['cart_goods'=>[],'sum_price'=>$sum_price,'products'=>$products,'product_count'=>$product_count];
        }
        return $param;
    }
}
