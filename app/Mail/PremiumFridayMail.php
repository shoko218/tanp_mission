<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PremiumFridayMail extends Mailable
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
          ->subject('今日はプレミアムフライデーです。1ヶ月お疲れ様です。')
          ->view('mail.stdmail')
          ->with(['img_path' => "image/premium_friday.jpg",'msg' => $this->user->last_name.$this->user->first_name."様、お疲れ様です。\n今日はプレミアムフライデーです。\n1ヶ月頑張った自分に、ご褒美あげませんか？",'link_path' => config('constant.domain')."/result?_token=yQ9lAaaNc7yjHmAfnvwM6TB0pQaGoO4wuN9ps21J&target_scene_id=16&target_genre_id=&target_relationship_id=14&target_gender=".$this->user->gender."&target_generation_id=".(intval(floor((intval(date ( 'Ymd', time ()))-intval(str_replace('-', '', $this->user->birthday)))/10000)/10)+1)."&sort_by=0&keyword="]);
    }
}
