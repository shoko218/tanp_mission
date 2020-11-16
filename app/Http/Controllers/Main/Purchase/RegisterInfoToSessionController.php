<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Lover;

class RegisterInfoToSessionController extends Controller
{
    public function __invoke(Request $request){//一度確認画面を挟むため、セッションに入力情報を保持
        if(Auth::check()&&$request->lover_id!=null){
            $lover=Lover::find($request->lover_id);
            if($lover==null||$lover->user_id!=Auth::user()->id){
                return back()->with('err_msg','エラーが発生しました。');
            }
        }
        $this->validate($request,Order::$rules);
        try {
            $request->session()->put('forwarding_last_name', $request->input('forwarding_last_name'));
            $request->session()->put('forwarding_first_name', $request->input('forwarding_first_name'));
            $request->session()->put('forwarding_last_name_furigana', $request->input('forwarding_last_name_furigana'));
            $request->session()->put('forwarding_first_name_furigana', $request->input('forwarding_first_name_furigana'));
            $request->session()->put('forwarding_postal_code', $request->input('forwarding_postal_code'));
            $request->session()->put('forwarding_prefecture_id', $request->input('forwarding_prefecture_id'));
            $request->session()->put('forwarding_address', $request->input('forwarding_address'));
            $request->session()->put('forwarding_telephone', preg_replace('/[^0-9]/', '', $request->input('forwarding_telephone')));
            if ($request->input('gender')!=null) {
                $request->session()->put('gender', $request->input('gender'));
            }else{
                $request->session()->put('gender', null);
            }
            if ($request->input('relationship_id')!=null) {
                $request->session()->put('relationship_id', $request->input('relationship_id'));
            }else{
                $request->session()->put('relationship_id', null);
            }
            if ($request->input('age')!=null) {
                $request->session()->put('age', $request->input('age'));
            }else{
                $request->session()->put('age', null);
            }
            if ($request->input('scene_id')!=null) {
                $request->session()->put('scene_id', $request->input('scene_id'));
            }else{
                $request->session()->put('scene_id', null);
            }
            if($request->input('lover_id')!=null){
                $request->session()->put('lover_id', $request->input('lover_id'));
            }else{
                $request->session()->put('lover_id', null);
            }
            $request->session()->put('user_last_name', $request->input('user_last_name'));
            $request->session()->put('user_first_name', $request->input('user_first_name'));
            $request->session()->put('user_last_name_furigana', $request->input('user_last_name_furigana'));
            $request->session()->put('user_first_name_furigana', $request->input('user_first_name_furigana'));
            $request->session()->put('user_postal_code', $request->input('user_postal_code'));
            $request->session()->put('user_prefecture_id', $request->input('user_prefecture_id'));
            $request->session()->put('user_address', $request->input('user_address'));
            $request->session()->put('user_email', $request->input('user_email'));
            $request->session()->put('user_telephone',$request->input('user_telephone'));
        } catch (\Throwable $th) {
            return back()->with('err_msg','エラーが発生しました。');
        }
        return redirect('/purchase/payment');
    }
}
