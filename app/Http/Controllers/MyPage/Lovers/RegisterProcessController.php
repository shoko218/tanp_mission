<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Lover;
use Illuminate\Support\Facades\Storage;

class RegisterProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,Lover::$rules);
        $lover = Lover::create(['last_name'=>$request->last_name,'first_name'=>$request->first_name,'last_name_furigana'=>$request->last_name_furigana,'first_name_furigana'=>$request->first_name_furigana,'birthday'=>$request->birthday,'gender'=>$request->gender,'relationship_id'=>$request->relationship_id,
        'user_id'=>$request->user_id,'postal_code'=>$request->postal_code,'prefecture_id'=>$request->prefecture_id,'address'=>$request->address,'telephone'=>$request->telephone]);
        if($request->file('image')!=null){
            $file_ex = $request->file('image')->getClientOriginalExtension();
            $file_name = uniqid(rand());
            if (env('APP_ENV') === 'production') {
                Storage::disk('s3')->putFileAs('/lover_imgs', $request->file('image'),$file_name.'.'.$file_ex, 'public');
            }else{
                $request->file('image')->storeAs('public/lover_imgs/',$file_name.'.'.$file_ex);
            }
            $lover->update(['img_path'=>$file_name.'.'.$file_ex]);
        }
        return redirect('/mypage/lovers/top')->with('suc_msg','追加しました。');
    }
}

