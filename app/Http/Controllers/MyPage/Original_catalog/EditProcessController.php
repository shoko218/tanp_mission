<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;

class EditProcessController extends Controller
{
    public function __invoke(Request $request){//カタログの変更を保存
        $this->validate($request,Catalog::$rules);
        Catalog::find($request->catalog_id)->fill($request->except(['catalog_id']))->save();
        return redirect('/mypage/original_catalog/'.$request->catalog_id)->with('suc_msg','変更しました。');
    }
}
