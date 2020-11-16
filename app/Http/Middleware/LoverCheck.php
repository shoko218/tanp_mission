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
    public function handle($request, Closure $next)
    {
        $lover=Lover::find($request->lover_id);//ユーザーが登録した大切な人か確認する
        if($lover==null||Auth::user()->id!=$lover->user_id){
            return redirect('/mypage/lovers/')->with('err_msg','エラーが発生しました。');
        }
        return $next($request);
    }
}
