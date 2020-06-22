<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product;

class ProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $product=Product::where('id',$request->input('id'))->first();
        return view('main.product')->with('product', $product);
    }
}
