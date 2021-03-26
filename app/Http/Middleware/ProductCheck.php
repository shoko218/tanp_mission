<?php

namespace App\Http\Middleware;

use App\Model\Product;
use Closure;

class ProductCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)//Productが存在しているかを確認
    {
        if ($request->product_id != null) {
            $product = Product::find($request->product_id);
            if ($product == null) {
                return redirect('/msg')->with('title', 'エラー')->with('msg', 'エラーが発生しました。');
            }
        } else {
            return redirect('/msg')->with('title', 'エラー')->with('msg', 'エラーが発生しました。');
        }
        return $next($request);
    }
}
