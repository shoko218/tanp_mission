<?php

namespace App\Http\Controllers\MyPage\Original_catalog;
use App\Http\Controllers\Controller;
use App\Model\Catalog;
use Illuminate\Http\Request;
use App\Model\Product;

class RegisterController extends Controller
{
    public function __invoke()//オリジナルカタログを登録
    {
        return view('mypage.original_catalog.register');
    }
}
