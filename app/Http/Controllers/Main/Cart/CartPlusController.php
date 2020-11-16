<?php

namespace App\Http\Controllers\Main\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Model\Cart;
use App\Library\BaseClass;
use Illuminate\Support\Facades\DB;

class CartPlusController extends Controller
{
    public function __invoke(Request $request)
    {
        if(Auth::check()){//会員ならDBでの処理
            DB::beginTransaction();
            try {
                $user_id=Auth::user()->id;
                $target=Cart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->first();//増やす対象の商品を取得
                if(!empty($target)){//レコードが存在していれば個数+1
                    $target->update(['count'=>$target->count+1]);
                }else{//レコードが存在していなければレコードを作成
                    Cart::create(['user_id'=>$user_id,'product_id'=>$request->product_id,'count'=>'1']);
                }

                $cart_goods=BaseClass::getProductsFromDBCart();//カート内の商品を取得
                $sum_price=BaseClass::calcPriceInTaxFromDBCart();//合計金額を計算
                $param=['cart_goods'=>[],'sum_price'=>[],'products'=>[],'product_count'=>[],'errMsg'=>''];//productsとproduct_countはCookieの処理の際の返り値なので空要素
                $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>[],'product_count'=>[],'errMsg'=>''];//productsとproduct_countはCookieの処理の際の返り値なので空要素
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                $cart_goods=BaseClass::getProductsFromDBCart();
                $sum_price=BaseClass::calcPriceInTaxFromDBCart();
                $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>[],'product_count'=>[],'errMsg'=>'エラーが発生しました。'];
            }
        }else{//非会員ならCookieでの処理
            try {
                $cart=Cookie::get('cart_product_ids');
                $new_cart=$cart.$request->product_id.',';//Cookieから取得した文字列の末尾にカートに入れる商品のidを追加
                Cookie::queue('cart_product_ids', $new_cart,86400);
                if($new_cart!=null){
                    list($products,$product_count)=BaseClass::getProductsFromCookieCart($new_cart);
                    $sum_price=BaseClass::calcPriceInTaxFromCookieCart($products,$product_count);
                    if($sum_price==-1) throw new Exception();
                }else{
                    $products=null;
                    $product_count=0;
                    $sum_price=0;
                }
                $param=['products'=>$products,'sum_price'=>$sum_price,'product_count'=>$product_count,'cart_goods'=>[],'errMsg'=>''];
            } catch (\Throwable $th) {
                Cookie::queue('cart_product_ids', $cart,86400);//元の値をCookieに設定
                list($cart_products,$cart_product_count)=BaseClass::getProductsFromCookieCart($cart);//Cookieの値から商品とその個数を配列化
                $sum_price=BaseClass::calcPriceInTaxFromCookieCart();
                $param=['cart_goods'=>[],'sum_price'=>$sum_price,'products'=>$cart_products,'product_count'=>$cart_product_count,'errMsg'=>'エラーが発生しました。'];//cart_goodsはDBの処理の際の返り値なので空要素
            }
        }
        return $param;
    }
}
