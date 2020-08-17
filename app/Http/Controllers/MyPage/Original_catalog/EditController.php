<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;


class EditController extends Controller
{
    public function __invoke(Request $request){
        if($request->catalog_id!=null){
            $catalog=Catalog::find($request->catalog_id);
        }elseif(session('catalog_id')!=null){
            $catalog=Catalog::find(session('catalog_id'));
        }else{
            return redirect('/mypage/original_catalog/top')->with('err_msg','エラーが発生しました。');
        }
        $param=['catalog'=>$catalog];
        return view('mypage.original_catalog.edit',$param);
    }
}
