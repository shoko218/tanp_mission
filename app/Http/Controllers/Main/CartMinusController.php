<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Model\Cart;

class CartMinusController extends Controller
{
    public function __invoke(Request $request)
    {
        if(Auth::check()){
            $target=Cart::where('user_id',$request->user_id)
            ->where('product_id',$request->product_id)
            ->first();
            $target->update(['count'=>$target->count-1]);
            if($target->count==0){
                $target->delete();
            }
        }else{
            $product_ids=explode(',',rtrim(Cookie::get('cart_product_ids'),','));
            for ($i=0;$i<count($product_ids);$i++) {
                if($request->product_id==$product_ids[$i]){
                    unset( $product_ids[$i]);
                    break;
                }
            }
            $cart_product_ids='';
            if($product_ids!=null){
                foreach ($product_ids as $product_id) {
                    $cart_product_ids=$cart_product_ids.$product_id.',';
                }
            }
            Cookie::queue('cart_product_ids', $cart_product_ids,86400);
        }
        return redirect('/cart');
    }
}
