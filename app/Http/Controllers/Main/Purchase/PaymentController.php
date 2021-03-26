<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Library\BaseClass;

class PaymentController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!($request->session()->has('forwarding_last_name') && $request->session()->has('forwarding_first_name') && $request->session()->has('forwarding_last_name_furigana') && $request->session()->has('forwarding_first_name_furigana') && $request->session()->has('forwarding_postal_code') && $request->session()->has('forwarding_prefecture_id') && $request->session()->has('forwarding_address') && $request->session()->has('forwarding_telephone') && $request->session()->has('user_last_name') && $request->session()->has('user_first_name') && $request->session()->has('user_last_name_furigana') && $request->session()->has('user_first_name_furigana') && $request->session()->has('user_postal_code') && $request->session()->has('user_prefecture_id') && $request->session()->has('user_address') && $request->session()->has('user_email') && $request->session()->has('user_telephone'))) {//必要な情報がセッション上に存在していない場合
            return redirect('/')->with('err_msg', 'エラーが発生しました。');
        }

        if ((Auth::check() && BaseClass::getProductsFromDBCart()->isEmpty()) || (!Auth::check() && Cookie::get('cart_product_ids')==null)) {//ログイン状況に応じたカート内に商品があるか調べる なければカート画面に遷移
            return redirect('/cart');
        }

        if (Auth::check()) {//会員の場合、DB上のカートから処理
            try {
                $cart_goods = BaseClass::getProductsFromDBCart();
                $sum_price = BaseClass::calcPriceInTaxFromDBCart();
                $param = ['cart_goods' => $cart_goods,'sum_price' => $sum_price,'products' => 0];
                return view('main.purchase.payment', $param);
            } catch (\Throwable $th) {
                return back()->with('err_msg', 'エラーが発生しました。');
            }
        } else {//非会員の場合、Cookie上のカートから処理
            try {
                list($products, $product_count) = BaseClass::getProductsFromCookieCart();
                $sum_price = BaseClass::calcPriceInTaxFromCookieCart();
                $param = ['products' => $products,'sum_price' => $sum_price,'product_count' => $product_count,'cart_goods' => 0];
                return view('main.purchase.payment', $param);
            } catch (\Throwable $th) {
                return back()->with('err_msg', 'エラーが発生しました。');
            }
        }
    }
}
