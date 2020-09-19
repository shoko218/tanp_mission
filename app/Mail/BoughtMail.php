<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BoughtMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $order,$order_logs,$sum_price;

    public function __construct($order,$order_logs,$sum_price)
    {
        $this->order=$order;
        $this->order_logs=$order_logs;
        $this->sum_price=$sum_price;
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
          ->subject('Pleasedより注文完了のお知らせ')
          ->view('mail.boughtMail')
          ->with(['order' => $this->order,'order_logs' => $this->order_logs,'sum_price'=>$this->sum_price]);
    }
}
