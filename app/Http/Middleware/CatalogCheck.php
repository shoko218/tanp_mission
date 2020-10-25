<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Catalog;
use Illuminate\Support\Facades\Auth;

class CatalogCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $catalog=Catalog::find($request->catalog_id);
        if($catalog==null||$catalog->user_id!=Auth::user()->id){
            return redirect('/mypage/original_catalog')->with('err_msg','エラーが発生しました。');
        }
        return $next($request);
    }
}