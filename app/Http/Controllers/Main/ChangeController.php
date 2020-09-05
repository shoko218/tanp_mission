<?php

namespace App\Http\Controllers\Main;
use App\Http\Controllers\Controller;
use App\Model\Product;

use Illuminate\Http\Request;

class ChangeController extends Controller
{
    public function __invoke()
    {
        $rand_product=Product::where('id','=',rand(1,Product::count()))->first();
        $params=['rand_product'=>$rand_product,'rand_product_genre'=>$rand_product->genre->name];
        return $params;
    }
}
