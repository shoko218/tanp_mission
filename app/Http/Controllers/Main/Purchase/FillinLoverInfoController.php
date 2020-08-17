<?php

namespace App\Http\Controllers\Main\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Lover;
use App\Model\Scene;
use App\Model\Prefecture;
use App\Model\Relationship;
use Illuminate\Support\Facades\Auth;

class FillinLoverInfoController extends Controller
{
    public function __invoke(Request $request){
        $lover_id=$request->lover_id;
        session()->flash('lover_id',$lover_id);
        return redirect('/purchase/fillin_info');
    }
}
