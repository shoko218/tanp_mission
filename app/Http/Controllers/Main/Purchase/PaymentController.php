<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Library\BaseClass;

class PaymentController extends Controller
{
    public function __invoke(Request $request){
        if(Auth::check()){
            $cart_goods=BaseClass::getProductsFromDBCart();
            if(!$cart_goods->isEmpty()){
                $sum_price=BaseClass::calcPriceInTaxFromDBCart();
            }else{
                return redirect('/cart');
            }
            $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>0];
        }else{
            if(Cookie::get('cart_product_ids')!=null){
                list($products,$product_count)=BaseClass::getProductsFromCookieCart();
                $sum_price=BaseClass::calcPriceInTaxFromCookieCart();
            }else{
                return redirect('/cart');
            }
            $param=['products'=>$products,'sum_price'=>$sum_price,'product_count'=>$product_count,'cart_goods'=>0];
        }
        return view('main.purchase.payment',$param);
    }
}
