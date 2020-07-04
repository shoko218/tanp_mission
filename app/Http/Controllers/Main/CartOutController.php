<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Cart;
use Illuminate\Support\Facades\Cookie;

class CartOutController extends Controller
{
    public function __invoke(Request $request)
    {
        if(Auth::check()){
        Cart::where('user_id',$request->user_id)
        ->where('product_id',$request->product_id)
        ->delete();
        }else{
            $product_ids=explode(',',rtrim(Cookie::get('cart_product_ids'),','));
            while( ($index = array_search( $request->product_id, $product_ids)) !== false ) {
                unset( $product_ids[$index] ) ;
            }
            $cookie='';
            if($product_ids!=null){
                foreach ($product_ids as $product_id) {
                    $cookie=$cookie.$product_id.',';
                }
            }
            Cookie::queue('cart_product_ids', $cookie,86400);
        }
        return redirect('/cart');
    }
}
