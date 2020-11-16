<?php

namespace App\Http\Controllers\MyPage\Reminder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Scene;
use App\Model\Lover;

class PostRegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        if($request->lover_id!=null){
            $lover=Lover::find($request->lover_id);
            if($lover==null||$lover->user_id!=Auth::user()->id){//自分の大切な人でなければ普通にリダイレクト
                return redirect('/mypage/reminder/register');
            }
        }
        return redirect('/mypage/reminder/register')->with('selected_lover_id',$request->lover_id);
    }
}
