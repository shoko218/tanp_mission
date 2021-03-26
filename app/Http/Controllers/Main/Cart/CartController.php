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
        try {
            if (Auth::check()) {//会員ならDBでの処理
                $cart_goods = BaseClass::getProductsFromDBCart();//カートに入っている商品を取得
                if (!$cart_goods->isEmpty()) {//カート内に商品があれば合計金額を計算
                    $sum_price = BaseClass::calcPriceInTaxFromDBCart();
                } else {
                    $sum_price = 0;
                }
                $param = ['cart_goods' => $cart_goods,'sum_price' => $sum_price,'products' => [],'product_count' => []];//productsとproduct_countはCookieの処理の際の返り値なので空要素
            } else {//非会員ならCookieでの処理
                if (Cookie::get('cart_product_ids') != null) {//カートに商品があれば合計金額を計算
                    list($products, $product_count) = BaseClass::getProductsFromCookieCart();//Cookieの値から商品とその個数を配列化
                    $sum_price = BaseClass::calcPriceInTaxFromCookieCart();
                } else {
                    $products = [];
                    $product_count = 0;
                    $sum_price = 0;
                }
                $param = ['cart_goods' => [],'sum_price' => $sum_price,'products' => $products,'product_count' => $product_count];//cart_goodsはDBの処理の際の返り値なので空要素
            }
        } catch (\Throwable $th) {
            return redirect('/msg')->with('title', 'エラー')->with('msg', 'エラーが発生しました。時間を開けて再度お試しください。');
        }
        return view('main.cart', $param);
    }
}
