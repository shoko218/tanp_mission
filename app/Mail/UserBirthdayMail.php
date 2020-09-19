<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserBirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $user;
    public function __construct($user)
    {
        $this->user=$user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
          ->from('shoko4prog@gmail.com')
          ->subject($this->user->last_name.$this->user->first_name.'様、お誕生日おめでとうございます。')
          ->view('mail.stdmail')
          ->with(['img_path' => "image/catalog_imgs/00002.png",'msg' => $this->user->last_name.$this->user->first_name."様、お誕生日おめでとうございます。\n自分にプレゼント、あげませんか？",'link_path' => config('constant.domain')."/result?_token=yQ9lAaaNc7yjHmAfnvwM6TB0pQaGoO4wuN9ps21J&target_scene_id=1&target_genre_id=&target_relationship_id=14&target_gender=".$this->user->gender."&target_generation_id=".(intval(floor((intval(date ( 'Ymd', time ()))-intval(str_replace('-', '', $this->user->birthday)))/10000)/10)+1)."&sort_by=0&keyword="]);
    }
}
