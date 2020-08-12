<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserBirthdayMail;

class SendUserBirthdayMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-ub-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user birthday mail';

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
        $users=User::all();
        foreach($users as $user){
            if($user->birthday->format('md')==date('md')){
                Mail::to($user->email)->send(new UserBirthdayMail($user));
            }
        }
    }
}
