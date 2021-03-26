<?php

namespace App\Http\Controllers\Main\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;
use Illuminate\Support\Facades\Cookie;
use App\Library\BaseClass;
use Exception;
use Illuminate\Support\Facades\DB;

class CartCompleteOutController extends Controller
{
    public function __invoke(Request $request)//商品の個数にかかわらず、カートから商品ごと削除する
    {
        if (Auth::check()) {//会員ならDBでの処理
            DB::beginTransaction();
            try {
                $user_id = Auth::user()->id;
                $target = Cart::where('user_id', '=', $user_id)->where('product_id', '=', $request->product_id)->first();
                $target->delete();

                $cart_goods = BaseClass::getProductsFromDBCart();
                if (!$cart_goods->isEmpty()) {//カート内に商品があれば合計金額を計算
                    $sum_price = BaseClass::calcPriceInTaxFromDBCart();
                } else {
                    $sum_price = 0;
                }
                $param = ['cart_goods' => $cart_goods,'sum_price' => $sum_price,'products' => [],'product_count' => [],'errMsg' => ''];//productsとproduct_countはCookieの処理の際の返り値なので空要素
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                $cart_goods = BaseClass::getProductsFromDBCart();
                $sum_price = BaseClass::calcPriceInTaxFromDBCart();
                $param = ['cart_goods' => $cart_goods,'sum_price' => $sum_price,'products' => [],'product_count' => [],'errMsg' => 'エラーが発生しました。'];
            }
        } else {//非会員ならCookieでの処理
            try {
                $cart = Cookie::get('cart_product_ids');
                $cart_product_ids = explode(',', trim($cart, ','));//一度配列に落とし込む
                for ($i = count($cart_product_ids)-1; $i>-1; $i--) {//インクリメントだと要素を削除した際にインデックスがずれるのでデクリメント
                    if ($request->product_id == $cart_product_ids[$i]) {//該当する商品を配列から見つけ、全て削除
                        unset($cart_product_ids[$i]);
                    }
                }
                $new_cart = '';
                if ($cart_product_ids != null) {//カートの中が空でなければ、カートの状態をCookieに設定するために配列の内容を文字列にする
                    foreach ($cart_product_ids as $cart_product_id) {
                        $new_cart = $new_cart.$cart_product_id.',';
                    }
                }
                Cookie::queue('cart_product_ids', $new_cart, 86400);//Cookieに設定

                if ($new_cart !=  null) {//カートに商品があれば合計金額を計算
                    list($new_cart_products, $new_cart_product_count) = BaseClass::getProductsFromCookieCart($new_cart);//Cookieの値から商品とその個数を配列化
                    $sum_price = BaseClass::calcPriceInTaxFromCookieCart($new_cart_products, $new_cart_product_count);
                    if ($sum_price == -1) {
                        throw new Exception();
                    }
                } else {
                    $new_cart_products = [];
                    $new_cart_product_count = 0;
                    $sum_price = 0;
                }
                $param = ['cart_goods' => [],'sum_price' => $sum_price,'products' => $new_cart_products,'product_count' => $new_cart_product_count,'errMsg' => ''];//cart_goodsはDBの処理の際の返り値なので空要素
            } catch (\Throwable $th) {
                Cookie::queue('cart_product_ids', $cart, 86400);//元の値をCookieに設定
                list($cart_products, $cart_product_count) = BaseClass::getProductsFromCookieCart($cart);//Cookieの値から商品とその個数を配列化
                $sum_price = BaseClass::calcPriceInTaxFromCookieCart();
                $param = ['cart_goods' => [],'sum_price' => $sum_price,'products' => $cart_products,'product_count' => $cart_product_count,'errMsg' => 'エラーが発生しました。'];//cart_goodsはDBの処理の際の返り値なので空要素
            }
        }
        return $param;
    }
}
