<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PremiumFridayMail;

class SendPremiumFridayMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-pf-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send premium friday mail';

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
            Mail::to($user->email)->send(new PremiumFridayMail($user));
        }
    }
}
