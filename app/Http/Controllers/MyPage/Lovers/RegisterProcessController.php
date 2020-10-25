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
            $file_name = uniqid(rand());
            $path=$request->image->path();
            $image=\Image::make($path);
            $image->fit(480,480,function($constraint){
                $constraint->upsize();
            });
            if (env('APP_ENV') === 'production') {
                Storage::disk('s3')->put('/lover_imgs/'.$file_name.'.jpg',(string)$image->encode(),'public');
            }else{
                $image->save('storage/lover_imgs/'.$file_name.'.jpg');
            }
            $lover->update(['img_path'=>$file_name.'.jpg']);
        }
        return redirect('/mypage/lovers/')->with('suc_msg','追加しました。');
    }
}

