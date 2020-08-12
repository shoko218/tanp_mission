<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoverEventMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $event;
    public function __construct($event)
    {
        $this->event=$event;
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
          ->subject($this->event->lover->last_name.$this->event->lover->first_name.'様とのイベントが近づいています。')
          ->view('mail.stdmail')
          ->with(['img_path' => "image/event_imgs/".sprintf('%05d', $this->event->scene_id).'.png','msg' => $this->event->lover->last_name.$this->event->lover->first_name."様とのイベント、\n「".$this->event->title."」が近づいてまいりました。\ntanp_missionでプレゼントを探しませんか？",'link_path' => "http://tanp_mission.jp/result?_token=yQ9lAaaNc7yjHmAfnvwM6TB0pQaGoO4wuN9ps21J&target_scene_id=".$this->event->scene_id."&target_genre_id=".$this->event->genre_id."&target_relationship_id=".$this->event->lover->relationship_id."&target_gender=".$this->event->lover->gender."&target_generation_id=".(intval(floor((intval(date ( 'Ymd', time ()))-intval(str_replace('-', '', $this->event->lover->birthday)))/10000)/10)+1)."&sort_by=0&keyword="]);
    }
}
