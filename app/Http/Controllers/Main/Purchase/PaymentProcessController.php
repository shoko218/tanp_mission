<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
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
        if (Auth::check()) {
            if(count(Cart::where('user_id', '=', Auth::user()->id)->get())==0){
                return redirect('/msg')->with('title', '不正なリダイレクト')->with('msg', '不正なリダイレクトを検出しました。最初からやり直してください。');
            }
        }else{
            if(Cookie::get('cart_product_ids')==''){
                return redirect('/msg')->with('title', '不正なリダイレクト')->with('msg', '不正なリダイレクトを検出しました。最初からやり直してください。');
            }
        }
        DB::beginTransaction();
        try {
            $old_product_ids=null;
            $order=new Order;
            $order->last_name=$request->last_name;
            $order->first_name=$request->first_name;
            $order->last_name_furigana=$request->last_name_furigana;
            $order->first_name_furigana=$request->first_name_furigana;
            $order->postal_code=$request->postal_code;
            $order->prefecture_id=$request->prefecture_id;
            $order->address=$request->address;
            $order->telephone=$request->telephone;
            if ($request->gender!=null) {
                $order->gender=$request->gender;
            }
            if ($request->relationship_id!=null) {
                $order->relationship_id=$request->relationship_id;
            }
            if ($request->age!=null) {
                if(($request->age/10+1)<11){
                    $order->generation_id=$request->age/10+1;
                }else{
                    $order->generation_id=10;
                }
            }
            if ($request->scene_id!=null) {
                $order->scene_id=$request->scene_id;
            }
            if ($request->user_id!=null) {
                $order->user_id=$request->user_id;
            }
            if ($request->lover_id!=null) {
                $order->lover_id=$request->lover_id;
            }
            $order->user_last_name=$request->user_last_name;
            $order->user_first_name=$request->user_first_name;
            $order->user_last_name_furigana=$request->user_last_name_furigana;
            $order->user_first_name_furigana=$request->user_first_name_furigana;
            $order->user_postal_code=$request->user_postal_code;
            $order->user_prefecture_id=$request->user_prefecture_id;
            $order->user_address=$request->user_address;
            $order->user_email=$request->user_email;
            $order->user_telephone=$request->user_telephone;
            $order->save();

            $order_id = $order->id;
            $request->session()->forget('lover_id');

            if (Auth::check()) {
                $user_id=Auth::user()->id;
                $cart_goods=Cart::where('user_id', '=', $user_id)->get();
                foreach ($cart_goods as $cart_good) {
                    $order_log=new Order_log;
                    $order_log->order_id=$order_id;
                    $order_log->product_id=$cart_good->product_id;
                    $order_log->count=$cart_good->count;
                    $order_log->save();
                }
            } else {
                $product_ids=explode(',', rtrim(Cookie::get('cart_product_ids'), ','));
                $product_notdup_ids=array_values(array_unique($product_ids));
                $products = new Collection();
                $product_count=array();
                foreach ($product_notdup_ids as $product_notdup_id) {
                    $product=Product::select(DB::raw('products.*'))
                    ->where('id', '=', $product_notdup_id)
                    ->first();
                    $products->push($product);
                }
                foreach ($product_notdup_ids as $product_notdup_id) {
                    $temp_count=0;
                    foreach ($product_ids as $product_id) {
                        if ($product_notdup_id==$product_id) {
                            $temp_count++;
                        }
                    }
                    $product_count[]=$temp_count;
                }
                foreach ($products as $key => $product) {
                    $order_log=new Order_log;
                    $order_log->order_id=$order_id;
                    $order_log->product_id=$product->id;
                    $order_log->count=$product_count[$key];
                    $order_log->save();
                }
            }

            if (Auth::check()) {
                $user_id=Auth::user()->id;
                $cart_goods=Cart::where('user_id', '=', $user_id)
                ->delete();
            } else {
                $old_product_ids=Cookie::get('cart_product_ids');
                $product_ids='';
                Cookie::queue('cart_product_ids', $product_ids, 0);
            }
            Stripe::setApiKey(config('constant.sec_key'));
            Charge::create(array(
                 'amount' => $request->sum_price,
                 'currency' => 'jpy',
                 'source' => $request->stripeToken,
            ));
            $order_logs=Order_log::where('order_id','=',$order->id)->get();
            Mail::to($request->user_email)->send(new BoughtMail($order,$order_logs,$request->sum_price));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if($old_product_ids!=null){
                Cookie::queue('cart_product_ids', $old_product_ids, 86400);
            }
            return redirect()->back()->with('err_msg', 'エラーが発生しました。');
        }
        return redirect('/msg')->with('title', '購入完了')->with('msg', '購入が完了しました。');
    }
}

