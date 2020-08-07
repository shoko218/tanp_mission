<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CatalogMail extends Mailable
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
          ->from('shoko4prog@gmail.com') // 送信元
          ->subject('tanp_missionよりカタログのお届け') // メールタイトル
          ->view('mail.catalog') // メール本文のテンプレート
          ->with(['catalog' => $this->catalog]);  // withでセットしたデータをviewへ渡す
        return $this->view('view.name');
    }
}
