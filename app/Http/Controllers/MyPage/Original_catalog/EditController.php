<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function __invoke($catalog_id){//カタログ編集画面を表示
        $catalog=Catalog::find($catalog_id);
        $param=['catalog'=>$catalog];
        return view('mypage.original_catalog.edit',$param);
    }
}
