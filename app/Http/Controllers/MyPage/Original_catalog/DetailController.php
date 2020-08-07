<?php

namespace App\Http\Controllers\MyPage\Original_catalog;
use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use App\Model\Product;

class DetailController extends Controller
{
    public function __invoke()
    {
        $result=Catalog::find(Request('id'));
        if($result->selected_id!=null){
            $selected=Product::find($result->selected_id);
        }else{
            $selected=null;
        }
        $param=['catalog'=>$result,'selected'=>$selected];
        return view('mypage.original_catalog.detail', $param);
    }
}
