<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Event;
use Carbon\Carbon;

class CleanEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean-events';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean events';

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
        $repeat_events=Event::whereDate('date','<', date('Y-m-d'))->where('is_repeat','=','1')->get();
        $old_event_day=new Carbon(date('Y-m-d',strtotime("-1 day")));
        $new_event_day=$old_event_day->addYear();
        foreach ($repeat_events as $repeat_event) {
            $repeat_event->update(['date'=>$new_event_day]);
        }
        $delete_events=Event::whereDate('date','<', date('Y-m-d'))->where('is_repeat','=','0')->get();
        foreach ($delete_events as $delete_event) {
            $delete_event->delete();
        }
    }
}
