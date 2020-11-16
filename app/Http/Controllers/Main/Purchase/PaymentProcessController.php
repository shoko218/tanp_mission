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

class PaymentProcessController extends Controller
{
    public function __invoke(Request $request){
        if (Auth::check()) {//カートの中身がない場合はエラー
            if(count(Cart::where('user_id', '=', Auth::user()->id)->get())===0){
                return redirect('/msg')->with('title','エラー')->with('msg','エラーが発生しました。時間を開けて再度お試しください。');
            }
        }else{
            if(Cookie::get('cart_product_ids')==''){
                return redirect('/msg')->with('title','エラー')->with('msg','エラーが発生しました。時間を開けて再度お試しください。');
            }
        }

        DB::beginTransaction();
        try {
            $old_cart=null;
            if (session('age')!=null) {//年齢から年代計算
                if((session('age')/10+1)<11){
                    $request->session()->put('generation_id',session('age')/10+1);
                }else{
                    $request->session()->put('generation_id',10);
                }
                $request->session()->forget('age');
            }

            $order=new Order($request->session()->all());//注文顧客データ保存
            if(Auth::check()){
                $order->user_id=Auth::user()->id;
            }
            $order->save();

            $order_log=new Order_log;
            if (Auth::check()) {//注文情報(注文idと商品と個数)作成
                $cart_goods=BaseClass::getProductsFromDBCart();
                foreach ($cart_goods as $cart_good) {
                    $order_log->order_id=$order->id;
                    $order_log->product_id=$cart_good->product_id;
                    $order_log->count=$cart_good->count;
                    $order_log->save();
                }
            } else {
                list($products,$product_count)=BaseClass::getProductsFromCookieCart();
                foreach ($products as $key => $product) {
                    $order_log->order_id=$order->id;
                    $order_log->product_id=$product->id;
                    $order_log->count=$product_count[$key];
                    $order_log->save();
                }
            }

            if (Auth::check()) { //商品削除処理
                $user_id=Auth::user()->id;
                Cart::where('user_id', '=', $user_id)->delete();
            } else {
                $old_cart=Cookie::get('cart_product_ids');
                $product_ids='';
                Cookie::queue('cart_product_ids', $product_ids, 0);
            }

            Stripe::setApiKey(config('constant.sec_key'));//支払い処理
            Charge::create(array(
                 'amount' => $request->sum_price,
                 'currency' => 'jpy',
                 'source' => $request->stripeToken,
            ));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            if($old_cart!=null){//Cookieの状態を元に戻す
                Cookie::queue('cart_product_ids', $old_cart, 86400);
            }

            return redirect()->back()->with('err_msg', 'エラーが発生しました。');
        }
        $order_logs=Order_log::where('order_id','=',$order->id)->get();
        Mail::to($order->user_email)->send(new BoughtMail($order,$order_logs,$request->sum_price));

        session()->forget('forwarding_last_name');//セッション情報の削除
        session()->forget('forwarding_first_name');
        session()->forget('forwarding_last_name_furigana');
        session()->forget('forwarding_first_name_furigana');
        session()->forget('forwarding_postal_code');
        session()->forget('forwarding_prefecture_id');
        session()->forget('forwarding_address');
        session()->forget('forwarding_telephone');
        if ($request->session()->has('gender')) {
            session()->forget('gender');
        }
        if ($request->session()->has('relationship_id')) {
            session()->forget('relationship_id');
        }
        if ($request->session()->has('generation_id')) {
            session()->forget('generation_id');
        }
        if ($request->session()->has('scene_id')) {
            session()->forget('scene_id');
        }
        if ($request->session()->has('user_id')) {
            session()->forget('user_id');
        }
        if ($request->session()->has('lover_id')) {
            session()->forget('lover_id');
        }
        session()->forget('user_last_name');
        session()->forget('user_first_name');
        session()->forget('user_last_name_furigana');
        session()->forget('user_first_name_furigana');
        session()->forget('user_postal_code');
        session()->forget('user_prefecture_id');
        session()->forget('user_address');
        session()->forget('user_email');
        session()->forget('user_telephone');
        return redirect('/msg')->with('title', '購入完了')->with('msg', '購入が完了しました。');
    }
}

