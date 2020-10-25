<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;

class DeleteProcessController extends Controller
{
    public function __invoke(Request $request){
        Catalog::find($request->catalog_id)->delete();
        return redirect('mypage/original_catalog')->with('suc_msg','削除しました。');
    }
}
