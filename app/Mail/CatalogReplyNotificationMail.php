<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CatalogReplyNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $catalog;

    public function __construct($catalog)
    {
        $this->catalog = $catalog;
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
          ->subject($this->catalog->name."様よりカタログのご返答が届いております。")
          ->view('mail.stdmail')
          ->with(['img_path' => null,'msg' => $this->catalog->name."様より"."カタログのご返答が届いております。\n下記ボタンよりtanp_missionにアクセスし、ご確認ください。",'link_path' => "http://tanp_mission.jp/mypage/original_catalog/top"]);
    }
}
