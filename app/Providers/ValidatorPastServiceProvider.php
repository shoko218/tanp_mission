<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use DateTime;

class ValidatorPastServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('past', function ($attribute, $value, $parameters, $validator) {//今日以前
            $date=new DateTime($value);
            $today=new DateTime();
            $today=date_create('today');
            if ($date>$today) { //明日以降
                return false;
            }
            return true;
        });
    }
}
