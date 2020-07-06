<?php

namespace App\Http\Controllers\Main\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Library\BaseClass;

class CartController extends Controller
{
    public function __invoke()
    {
        if(Auth::check()){
            $cart_goods=BaseClass::getProductsFromDB();
            if(!$cart_goods->isEmpty()){
                $sum_price=BaseClass::calcPriceInTaxFromDB($cart_goods);
            }else{
                $cart_goods=null;
                $sum_price=0;
            }
            $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>0];
        }else{
            if(Cookie::get('cart_product_ids')!=null){
                list($products,$product_count)=BaseClass::getProductsFromCookie();
                $sum_price=BaseClass::calcPriceInTaxFromCookie($products,$product_count);
            }else{
                $products=null;
                $product_count=0;
                $sum_price=0;
            }
            $param=['products'=>$products,'sum_price'=>$sum_price,'product_count'=>$product_count,'cart_goods'=>0];
        }
        return view('main.cart',$param);
    }
}
