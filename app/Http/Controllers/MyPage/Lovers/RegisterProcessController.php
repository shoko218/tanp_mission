<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Lover;

class RegisterProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,Lover::$rules);
        $lover = Lover::create(['last_name'=>$request->last_name,'first_name'=>$request->first_name,'last_name_furigana'=>$request->last_name_furigana,'first_name_furigana'=>$request->first_name_furigana,'birthday'=>$request->birthday,'gender'=>$request->gender,'relationship_id'=>$request->relationship_id,
        'user_id'=>$request->user_id,'postal_code'=>$request->postal_code,'prefecture_id'=>$request->prefecture_id,'address'=>$request->address,'telephone'=>$request->telephone,'is_there_img'=>false]);
        return redirect('/mypage/lovers/top');
    }
}
