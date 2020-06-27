<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Favorite;

class ProductfavoriteController extends Controller
{
    public function __invoke(Request $request)
    {
        $favorite=Favorite::create(['user_id'=>$request->user_id,'product_id'=>$request->product_id]);
        return redirect()->back();
    }
}
