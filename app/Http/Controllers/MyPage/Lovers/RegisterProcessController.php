<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Lover;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterProcessController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,Lover::$rules);
        DB::beginTransaction();
        try {
            $lover = new Lover();
            $lover->user_id=Auth::user()->id;
            $lover->fill($request->except('image'))->save();

            if($request->file('image')!=null){
                $file_name = uniqid(rand());
                $path=$request->image->path();
                $image=\Image::make($path);
                $image->fit(480,480,function($constraint){//リサイズ
                    $constraint->upsize();
                });
                $lover->img_path=$file_name.'.jpg';
                $lover->save();
                if (env('APP_ENV') === 'production') {
                    Storage::disk('s3')->put('/lover_imgs/'.$file_name.'.jpg',(string)$image->encode(),'public');
                }else{
                    $image->save('storage/lover_imgs/'.$file_name.'.jpg');
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('err_msg','エラーが発生しました。');
        }
        return redirect('/mypage/lovers/')->with('suc_msg','追加しました。');
    }
}

