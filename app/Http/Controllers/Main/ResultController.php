<?php

namespace App\Http\Controllers\Main;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function __invoke(Request $request)
    {
        $word=$request->input('word');
        return view('main.result')->with('word', $word);
    }
}
