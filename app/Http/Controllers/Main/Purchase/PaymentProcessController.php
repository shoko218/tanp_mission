<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use App\Library\BaseClass;
use App\Model\Order;
use App\Model\Order_log;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Collection;
use App\Model\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\BoughtMail;
use Illuminate\Support\Facades\Log;

class PaymentProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        if (!($request->session()->has('forwarding_last_name') && $request->session()->has('forwarding_first_name') && $request->session()->has('forwarding_last_name_furigana') && $request->session()->has('forwarding_first_name_furigana') && $request->session()->has('forwarding_postal_code') && $request->session()->has('forwarding_prefecture_id') && $request->session()->has('forwarding_address') && $request->session()->has('forwarding_telephone') && $request->session()->has('user_last_name') && $request->session()->has('user_first_name') && $request->session()->has('user_last_name_furigana') && $request->session()->has('user_first_name_furigana') && $request->session()->has('user_postal_code') && $request->session()->has('user_prefecture_id') && $request->session()->has('user_address') && $request->session()->has('user_email') && $request->session()->has('user_telephone'))) {//必要な情報がセッション上に存在していない場合
            return redirect('/msg')->with('title', 'エラー')->with('msg', 'エラーが発生しました。再度お試しください。');
        }

        if ((Auth::check() && BaseClass::getProductsFromDBCart()->isEmpty()) || (!Auth::check() && Cookie::get('cart_product_ids') == null)) {//ログイン状況に応じたカート内に商品があるか調べる なければカート画面に遷移
            return redirect('/cart');
        }

        DB::beginTransaction();
        try {
            $old_cart = null;
            if (session('age') != null) {//年齢から年代計算
                if ((session('age')/10+1)<11) {
                    $request->session()->put('generation_id', session('age')/10+1);
                } else {
                    $request->session()->put('generation_id', 10);
                }
                $request->session()->forget('age');
            }

            $order = new Order($request->session()->all());//注文顧客データ保存
            if (Auth::check()) {
                $order->user_id = Auth::user()->id;
            }
            $order->save();

            if (Auth::check()) {//注文情報(注文idと商品と個数)作成
                $cart_goods = BaseClass::getProductsFromDBCart();
                foreach ($cart_goods as $cart_good) {
                    $order_log = new Order_log;
                    $order_log->order_id = $order->id;
                    $order_log->product_id = $cart_good->product_id;
                    $order_log->count = $cart_good->count;
                    $order_log->save();
                }
            } else {
                list($products, $product_count) = BaseClass::getProductsFromCookieCart();
                foreach ($products as $key => $product) {
                    $order_log = new Order_log;
                    $order_log->order_id = $order->id;
                    $order_log->product_id = $product->id;
                    $order_log->count = $product_count[$key];
                    $order_log->save();
                }
            }

            if (Auth::check()) { //商品削除処理
                $price = BaseClass::calcPriceInTaxFromDBCart();
                $user_id = Auth::user()->id;
                Cart::where('user_id', '=', $user_id)->delete();
            } else {
                $price = BaseClass::calcPriceInTaxFromCookieCart();
                $old_cart = Cookie::get('cart_product_ids');
                $product_ids = '';
                Cookie::queue('cart_product_ids', $product_ids, 0);
            }

            Stripe::setApiKey(config('constant.sec_key'));//支払い処理
            Charge::create(array(
                 'amount' => $price,
                 'currency' => 'jpy',
                 'source' => $request->stripeToken,
            ));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if ($old_cart != null) {//Cookieの状態を元に戻す
                Cookie::queue('cart_product_ids', $old_cart, 86400);
            }
            Log::info($e);
            return redirect()->back()->with('err_msg', 'エラーが発生しました。');
        }

        $order_logs = Order_log::where('order_id', '=', $order->id)->get();
        Mail::to($order->user_email)->send(new BoughtMail($order, $order_logs, $price));

        session()->forget(['forwarding_last_name','forwarding_first_name','forwarding_last_name_furigana','forwarding_first_name_furigana','forwarding_postal_code','forwarding_prefecture_id','forwarding_address','forwarding_telephone','gender','relationship_id','generation_id','scene_id','user_id','lover_id','user_last_name','user_first_name','user_last_name_furigana','user_first_name_furigana','user_postal_code','user_prefecture_id','user_address','user_email','user_telephone']);//セッション情報の削除

        return redirect('/msg')->with('title', '購入完了')->with('msg', '購入が完了しました。');
    }
}
