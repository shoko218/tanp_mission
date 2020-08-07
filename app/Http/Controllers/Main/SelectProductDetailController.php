<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Product;

class SelectProductDetailController extends Controller
{
    public function __invoke(Request $request)
    {
        $product=Product::where('id',$request->input('id'))->first();
        $param=['product'=>$product];
        return view('main.select_product_detail',$param);
    }
}
