<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function __invoke(Request $request){
        $catalog=Catalog::find($request->catalog_id);
        $param=['catalog'=>$catalog];
        return view('mypage.original_catalog.edit',$param);
    }
}
