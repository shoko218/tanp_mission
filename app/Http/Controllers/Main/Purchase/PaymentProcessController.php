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

class PaymentProcessController extends Controller
{
    public function __invoke(Request $request){
        Stripe::setApiKey(config('constant.sec_key'));
        Charge::create(array(
             'amount' => $request->sum_price,
             'currency' => 'jpy',
             'source'=> request()->stripeToken,
        ));
        $order=new Order;
        $order->last_name=$request->session()->get('last_name');
        $order->first_name=$request->session()->get('first_name');
        $order->last_name_furigana=$request->session()->get('last_name_furigana');
        $order->first_name_furigana=$request->session()->get('first_name_furigana');
        $order->postal_code=$request->session()->get('postal_code');
        $order->prefecture_id=$request->session()->get('prefecture_id');
        $order->address=$request->session()->get('address');
        $order->telephone=$request->session()->get('telephone');
        if($request->session()->exists('gender')){
            $order->gender=$request->session()->get('gender');
        }
        if($request->session()->exists('relationship_id')){
            $order->relationship_id=$request->session()->get('relationship_id');
        }
        if($request->session()->exists('age')){
            $order->generation_id=($request->session()->get('age')/10)+1;
        }
        if($request->session()->exists('scene_id')){
            $order->scene_id=$request->session()->get('scene_id');
        }
        if($request->session()->exists('user_id')){
            $order->user_id=$request->session()->get('user_id');
        }
        if($request->session()->exists('lover_id')&&$request->session()->get('lover_id')!=0){
            $order->lover_id=$request->session()->get('lover_id');
        }
        $order->save();

        $order_id = $order->id;

        if(Auth::check()){
            $user_id=Auth::user()->id;
            $cart_goods=Cart::where('user_id','=',$user_id)->get();
            foreach ($cart_goods as $cart_good) {
                $order_log=new Order_log;
                $order_log->order_id=$order_id;
                $order_log->product_id=$cart_good->product_id;
                $order_log->count=$cart_good->count;
                $order_log->save();
            }
        }else{
            $product_ids=explode(',',rtrim(Cookie::get('cart_product_ids'),','));
            $product_notdup_ids=array_values(array_unique($product_ids));
            $products = new Collection();
            $product_count=array();
            foreach ($product_notdup_ids as $product_notdup_id) {
                $product=Product::select(DB::raw('products.*'))
                ->where('id','=',$product_notdup_id)
                ->first();
                $products->push($product);
            }
            foreach ($product_notdup_ids as $product_notdup_id) {
                $temp_count=0;
                foreach ($product_ids as $product_id) {
                    if($product_notdup_id==$product_id){
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

        if(Auth::check()){
            $user_id=Auth::user()->id;
            $cart_goods=Cart::where('user_id','=',$user_id)
            ->delete();
        }else{
            $product_ids='';
            Cookie::queue('cart_product_ids', $product_ids,0);
        }
        return redirect('/msg')->with('title','購入完了')->with('msg','購入が完了しました。');
    }
}
