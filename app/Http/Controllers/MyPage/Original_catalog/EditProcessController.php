<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;

class EditProcessController extends Controller
{
    public function __invoke(Request $request)//カタログの変更を保存
    {
        $catalog = Catalog::find($request->catalog_id);
        if ($catalog->did_send_mail) {
            return redirect('mypage/original_catalog')->with('err_msg', '既に相手に送っているカタログは編集できません。');
        }
        $this->validate($request, Catalog::$rules);
        $catalog->fill($request->except(['catalog_id']))->save();
        return redirect('/mypage/original_catalog/'.$request->catalog_id)->with('suc_msg', '変更しました。');
    }
}
