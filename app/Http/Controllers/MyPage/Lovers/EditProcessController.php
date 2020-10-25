<?php

namespace App\Http\Controllers\MyPage\Lovers;

use App\Http\Controllers\Controller;
use App\Model\Lover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EditProcessController extends Controller
{
    public function __invoke(Request $request){
        $this->validate($request,Lover::$rules);
        $lover=Lover::find($request->lover_id);
        $lover->fill($request->except(['lover_id','image']))->save();
        if($request->file('image')!=null){
            $file_name = uniqid(rand());
            $path=$request->image->path();
            $image=\Image::make($path);
            $image->fit(480,480,function($constraint){
                $constraint->upsize();
            });
            if (env('APP_ENV') === 'production') {
                if($lover->img_path!=null){
                    Storage::disk('s3')->delete('/lover_imgs/'.$lover->img_path);
                }
                Storage::disk('s3')->put('/lover_imgs/'.$file_name.'.jpg', (string)$image, 'public');
            }else{
                if($lover->img_path!=null){
                    Storage::delete('public/lover_imgs/'.$lover->img_path);
                }
                $image->save('storage/lover_imgs/'.$file_name.'.jpg');
            }
            $lover->update(['img_path'=>$file_name.'.jpg']);
        }
        // if($request->file('image')!=null){
        //     $file_ex = $request->file('image')->getClientOriginalExtension();
        //     $file_name = uniqid(rand());
        //     if (env('APP_ENV') === 'production') {
        //         if($lover->img_path!=null){
        //             Storage::disk('s3')->delete('/lover_imgs/'.$lover->img_path);
        //         }
        //         Storage::disk('s3')->putFileAs('/lover_imgs', $request->file('image'),$file_name.'.'.$file_ex, 'public');
        //     }else{
        //         if($lover->img_path!=null){
        //             Storage::delete('public/lover_imgs/'.$lover->img_path);
        //         }
        //         $request->file('image')->storeAs('public/lover_imgs/',$file_name.'.'.$file_ex);
        //     }
        //     $lover->update(['img_path'=>$file_name.'.'.$file_ex]);
        // }
        return redirect('/mypage/lovers/'.$lover->id)->with('suc_msg','変更しました。')->with('lover_id',$request->lover_id);
    }
}
