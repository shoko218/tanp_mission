<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __invoke(Request $request)
    {
        $product_id=$request->input('id');
        return view('main.product')->with('product_id', $product_id);
    }
}
