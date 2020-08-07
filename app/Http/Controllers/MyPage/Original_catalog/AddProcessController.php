<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Model\Catalog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddProcessController extends Controller
{
    public function __invoke(Request $request){
        $already=DB::table('catalog_product')
        ->select('*')
        ->where('catalog_id','=',$request->id)
        ->where('product_id','=',$request->session()->get('product_id'))
        ->first();
        if($already){
            return redirect('mypage/original_catalog/detail')->with('catalog_id',$request->id)->with('err_msg','その商品は既にこのカタログに追加されています。');
        }else{
            $catalog=Catalog::find($request->id);
            $catalog->products()->attach($request->session()->get('product_id'));
            return redirect('mypage/original_catalog/detail')->with('catalog_id',$request->id)->with('suc_msg','追加しました。');
        }
    }
}
