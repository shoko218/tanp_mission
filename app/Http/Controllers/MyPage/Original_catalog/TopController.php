<?php

namespace App\Http\Controllers\MyPage\Original_catalog;
use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function __invoke()
    {
        $results=Catalog::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->orderBy('id','desc')
        ->paginate(10);
        $param=['results'=>$results];
        return view('mypage.original_catalog.top',$param);
    }
}
