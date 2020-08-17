<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;

class RegisterInfoToSessionController extends Controller
{
    public function __invoke(Request $request){
        $this->validate($request,Order::$rules);
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
        }
        if ($request->input('relationship_id')!=null) {
            $request->session()->put('relationship_id', $request->input('relationship_id'));
        }
        if ($request->input('age')!=null) {
            $request->session()->put('age', $request->input('age'));
        }
        if ($request->input('scene_id')!=null) {
            $request->session()->put('scene_id', $request->input('scene_id'));
        }
        if($request->input('user_id')!=null){
            $request->session()->put('user_id', $request->input('user_id'));
        }
        if($request->input('lover_id')!=null){
            $request->session()->put('lover_id', $request->input('lover_id'));
        }
        $request->session()->put('user_last_name', $request->input('user_last_name'));
        $request->session()->put('user_first_name', $request->input('user_first_name'));
        $request->session()->put('user_last_name_furigana', $request->input('user_last_name_furigana'));
        $request->session()->put('user_first_name_furigana', $request->input('user_first_name_furigana'));
        $request->session()->put('user_postal_code', $request->input('user_postal_code'));
        $request->session()->put('user_prefecture_id', $request->input('user_prefecture_id'));
        $request->session()->put('user_address', $request->input('user_address'));
        $request->session()->put('user_telephone',$request->input('user_telephone'));
        return redirect('/purchase/payment');
    }
}
