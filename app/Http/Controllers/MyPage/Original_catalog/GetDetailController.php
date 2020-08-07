<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Catalog;
use App\Model\Product;

class GetDetailController extends Controller
{
    public function __invoke(Request $request){
        if(session('catalog_id')!=null){
            $result=Catalog::find(session('catalog_id'));
            if($result->selected_id!=null){
                $selected=Product::find($result->selected_id);
            }else{
                $selected=null;
            }
            $param=['catalog'=>$result,'selected'=>$selected];
            return view('mypage.original_catalog.detail', $param);
        }else{
            return redirect('mypage/original_catalog/top');
        }
    }
}
