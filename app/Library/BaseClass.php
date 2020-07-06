<?php
namespace App\Library;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Model\Product;
use Illuminate\Database\Eloquent\Collection;

class BaseClass{
    public static function getProductsFromDB(){
        $user_id=Auth::user()->id;
        $cart_goods=Cart::join('products','products.id','=','product_id')
            ->select(DB::raw('carts.*'))
            ->where('user_id','=',$user_id)
            ->get();
        return $cart_goods;
    }

    public static function getProductsFromCookie(){
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
        return array($products,$product_count);
    }

    public static function calcPriceInTaxFromDB($cart_goods){
        $sum_price=0.0;
        foreach ($cart_goods as $cart_good) {
            if ($cart_good->product->genre_id==1) {
                $sum_price+=$cart_good->product->price*$cart_good->count*1.08;
            }else{
                $sum_price+=$cart_good->product->price*$cart_good->count*1.1;
            }
        }
        return $sum_price;
    }

    public static function calcPriceInTaxFromCookie($products,$product_count){
        $sum_price=0.0;
        foreach ($products as $key => $product) {
            if($product->genre_id==1){
                $sum_price+=$product->price*$product_count[$key]*1.08;
            }else{
                $sum_price+=$product->price*$product_count[$key]*1.1;
            }
        }
        return $sum_price;
    }
}