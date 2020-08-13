<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prefecture;
use App\Model\Relationship;
use App\Model\Lover;

class EditController extends Controller
{
    public function __invoke(Request $request)
    {
        $lover=Lover::find($request->lover_id);
        $prefectures = Prefecture::select('id','name')->get();
        $relationships = Relationship::select('id','name')->get();
        $param=['prefectures'=>$prefectures,'relationships'=>$relationships,'lover'=>$lover];
        return view('mypage.lovers.edit',$param);
    }
}
