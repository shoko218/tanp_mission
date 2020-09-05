<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Favorite;
use Illuminate\Support\Facades\Auth;

class ProductFavoriteController extends Controller
{
    public function __invoke(Request $request){
        $user_id=Auth::user()->id;
        $favorited=Favorite::where('product_id',$request->product_id)->where('user_id',$user_id)->first();
        if($favorited==null){
            Favorite::create(['user_id'=>$user_id,'product_id'=>$request->product_id]);
        }else{
            $favorited->delete();
        }
        if((Favorite::where('product_id',$request->product_id)->where('user_id',$user_id)->first())!=null){
            $is_fav=true;
        }else{
            $is_fav=false;
        }
        $params=['is_fav'=>$is_fav];
        return $params;
    }
}