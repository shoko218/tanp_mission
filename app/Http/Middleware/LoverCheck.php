<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Lover;
use Illuminate\Support\Facades\Auth;

class LoverCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)//大切な人idが指定されているか、大切な人が存在しているか、ユーザーの大切な人かを確認
    {
        if($request->lover_id!=null){
            $lover=Lover::find($request->lover_id);
            if($lover==null||$lover->user_id!=Auth::user()->id){
                return redirect('/mypage/lovers')->with('err_msg','エラーが発生しました。');
            }
        }else{
            return redirect('/mypage/lovers')->with('err_msg','エラーが発生しました。');
        }
        return $next($request);
    }
}
