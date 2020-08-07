<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Catalog;
use Illuminate\Support\Facades\Auth;

class SelectCatalogController extends Controller
{
    public function __invoke(Request $request){
        $request->session()->put('product_id', $request->product_id);
        $results=Catalog::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('did_send_mail','=',false)
        ->orderBy('id','desc')
        ->paginate(10);
        $param=['results'=>$results];
        return view('mypage.original_catalog.select_catalog',$param);
    }
}
