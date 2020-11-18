<?php

namespace App\Http\Controllers\MyPage\Original_catalog;
use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use App\Model\Product;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function __invoke($catalog_id)//カタログの詳細を表示
    {
        if($catalog->selected_id!=null){
            $selected=Product::find($catalog->selected_id);
        }else{
            $selected=null;
        }
        $param=['catalog'=>$catalog,'selected'=>$selected];
        return view('mypage.original_catalog.detail', $param);
    }
}
