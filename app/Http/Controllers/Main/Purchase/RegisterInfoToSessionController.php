<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;

class RegisterInfoToSessionController extends Controller
{
    public function __invoke(Request $request){
        $this->validate($request,Order::$rules);
        $request->session()->put('last_name', $request->input('last_name'));
        $request->session()->put('first_name', $request->input('first_name'));
        $request->session()->put('last_name_furigana', $request->input('last_name_furigana'));
        $request->session()->put('first_name_furigana', $request->input('first_name_furigana'));
        $request->session()->put('postal_code', $request->input('postal_code'));
        $request->session()->put('prefecture_id', $request->input('prefecture_id'));
        $request->session()->put('address', $request->input('address'));
        $request->session()->put('telephone', $request->input('telephone'));
        if ($request->input('gender')) {
            $request->session()->put('gender', $request->input('gender'));
        }
        if ($request->input('relationship_id')) {
            $request->session()->put('relationship_id', $request->input('relationship_id'));
        }
        if ($request->input('age')) {
            $request->session()->put('age', $request->input('age'));
        }
        if ($request->input('scene_id')) {
            $request->session()->put('scene_id', $request->input('scene_id'));
        }
        if($request->input('user_id')){
            $request->session()->put('user_id', $request->input('user_id'));
        }
        if($request->input('lover_id')){
            $request->session()->put('lover_id', $request->input('lover_id'));
        }
        return redirect('/purchase/payment');
    }
}
