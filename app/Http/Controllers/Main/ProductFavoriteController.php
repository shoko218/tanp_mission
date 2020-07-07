<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductFavoriteController extends Controller
{
    public function __invoke(Request $request){
        $favorite=Favorite::create(['user_id'=>$request->user_id,'product_id'=>$request->product_id]);
        return redirect()->back();
    }
}
