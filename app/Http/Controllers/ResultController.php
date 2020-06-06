<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __invoke(Request $request)
    {
        $word=$request->input('word');
        return view('main.result')->with('word', $word);
    }
}
