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
          ->from('shoko4prog@gmail.com')
          ->subject('tanp_missionよりカタログのお届けです')
          ->view('mail.stdmail')
          ->with(['img_path' => 'image/catalog_imgs/'.sprintf('%05d', $this->catalog->img_num).'.png','msg' => $this->catalog->user->last_name.$this->catalog->user->first_name."様より".$this->catalog->name."様専用のカタログをお届けに参りました。\nお好きな商品をお選びください。",'link_path' => "http://tanp_mission.jp/select_product/".$this->catalog->url_str]);
    }
}
