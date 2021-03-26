<?php

namespace App\Http\Controllers\MyPage\Original_catalog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Catalog;
use Illuminate\Support\Facades\Auth;

class SelectCatalogController extends Controller
{
    public function __invoke($product_id)//商品を入れるカタログを選ぶ画面を表示
    {
        $results = Catalog::select('*')
        ->where('user_id', '=', Auth::user()->id)
        ->where('did_send_mail', '=', false)
        ->orderBy('id', 'desc')
        ->paginate(12);
        $param = ['results' => $results,'product_id' => $product_id];
        return view('mypage.original_catalog.select_catalog', $param);
    }
}
