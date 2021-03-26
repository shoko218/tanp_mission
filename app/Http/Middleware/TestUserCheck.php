<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TestUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)//テストユーザーではないかを確認
    {
        if (Auth::user()->email == 'test@example.com') {
            return redirect('/msg')->with('title', 'エラー')->with('msg', 'テストアカウントは編集・削除できません。');
        }
        return $next($request);
    }
}
