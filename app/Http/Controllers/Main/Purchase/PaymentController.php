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
        if(Auth::check()){//会員の場合、DB上のカートから処理
            try {
                $cart_goods=BaseClass::getProductsFromDBCart();
                if(!$cart_goods->isEmpty()){//カートの中に物があれば合計金額を計算
                    $sum_price=BaseClass::calcPriceInTaxFromDBCart();
                }else{//なければカート画面に遷移
                    return redirect('/cart');
                }
                $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>0];
                return view('main.purchase.payment',$param);
            } catch (\Throwable $th) {
                return back()->with('err_msg','エラーが発生しました。');
            }
        }else{//非会員の場合、Cookie上のカートから処理
            try {
                if(Cookie::get('cart_product_ids')!=null){//カートの中に物があれば合計金額を計算
                    list($products,$product_count)=BaseClass::getProductsFromCookieCart();
                    $sum_price=BaseClass::calcPriceInTaxFromCookieCart();
                }else{//なければカート画面に遷移
                    return redirect('/cart');
                }
                $param=['products'=>$products,'sum_price'=>$sum_price,'product_count'=>$product_count,'cart_goods'=>0];
                return view('main.purchase.payment',$param);
            } catch (\Throwable $th) {
                return back()->with('err_msg','エラーが発生しました。');
            }
        }
    }
}
