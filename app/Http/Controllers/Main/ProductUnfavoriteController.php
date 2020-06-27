<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Favorite;

class ProductUnfavoriteController extends Controller
{
    public function __invoke(Request $request)
    {
        Favorite::where('user_id',$request->user_id)
        ->where('product_id',$request->product_id)
        ->delete();
        return redirect()->back();
    }
}
