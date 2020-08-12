<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\LoverEventMail;
use App\Model\Event;

class SendLoverEventMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-le-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Lover Event Mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $events=Event::all();
        foreach($events as $event){
            if(str_replace("-","",$event->date)==date('Ymd',strtotime("+4 week"))){
                Mail::to($event->lover->user->email)->send(new LoverEventMail($event));
            }
        }
    }
}
