<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use App\Model\Favorite;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function __invoke()
    {
        $user_id=Auth::user()->id;
        $favorite_products=Product::join('favorites','products.id','=','product_id')
        ->select(DB::raw('products.*'))
        ->where('favorites.user_id','=',$user_id)
        ->paginate(12);
        $param=['favorite_products'=>$favorite_products];
        return view('mypage.favorite',$param);
    }
}
