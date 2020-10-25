<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Prefecture;
use App\Model\Relationship;
use App\Model\Lover;
use Illuminate\Support\Facades\Auth;

class EditController extends Controller
{
    public function __invoke($lover_id)
    {
        $lover=Lover::find($lover_id);
        $prefectures = Prefecture::select('id','name')->get();
        $relationships = Relationship::select('id','name')->get();
        $param=['prefectures'=>$prefectures,'relationships'=>$relationships,'lover'=>$lover];
        return view('mypage.lovers.edit',$param);
    }
}
