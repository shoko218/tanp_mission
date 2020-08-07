<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemoveProcessController extends Controller
{
    public function __invoke(Request $request){
        DB::table('catalog_product')
        ->select('*')
        ->where('catalog_id','=',$request->catalog_id)
        ->where('product_id','=',$request->product_id)
        ->delete();
        return redirect('mypage/original_catalog/detail')->with('catalog_id',$request->catalog_id)->with('suc_msg','削除しました。');
    }
}
