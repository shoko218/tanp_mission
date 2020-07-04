<?php

namespace App\Http\Controllers\Main\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cart;
use App\Model\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Collection;

class CartController extends Controller
{
    public function __invoke()
    {
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $cart_goods=Cart::join('products','products.id','=','product_id')
            ->select(DB::raw('carts.*'))
            ->where('user_id','=',$user_id)
            ->get();
            if($cart_goods->isEmpty()){
                $cart_goods=null;
            }
            $sum_price=0.0;
            if($cart_goods!=null){
                foreach ($cart_goods as $cart_good) {
                    if ($cart_good->product->genre_id==1) {
                        $sum_price+=$cart_good->product->price*$cart_good->count*1.08;
                    }else{
                        $sum_price+=$cart_good->product->price*$cart_good->count*1.1;
                    }
                }
            }
            $param=['cart_goods'=>$cart_goods,'sum_price'=>$sum_price,'products'=>null];
        }else{
            if(Cookie::get('cart_product_ids')!=null){
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
            }else{
                $products=null;
                $product_count=null;
            }
            $sum_price=0;
            if($products!=null){
                foreach ($products as $key => $product) {
                    if($product->genre_id==1){
                        $sum_price+=$product->price*$product_count[$key]*1.08;
                    }else{
                        $sum_price+=$product->price*$product_count[$key]*1.1;
                    }
                }
            }
            $param=['products'=>$products,'sum_price'=>$sum_price,'product_count'=>$product_count,'cart_goods'=>null];
        }
        return view('main.cart',$param);
    }
}
