<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Event;
use Illuminate\Support\Facades\Auth;

class EventCheck
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
        $event=Event::find($request->event_id);
        if($event==null||Auth::user()->id!=$event->lover->user_id){
            return redirect('/mypage/reminder')->with('err_msg','エラーが発生しました。');
        }
        return $next($request);
    }
}
