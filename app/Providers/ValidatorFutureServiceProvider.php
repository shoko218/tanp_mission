<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use DateTime;

class ValidatorFutureServiceProvider extends ServiceProvider
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
        Validator::extend('future', function ($attribute, $value, $parameters, $validator) {//(明日以降 イベントとか)
            $date=new DateTime($value);
            $today=new DateTime();
            $today=date_create('today');
            if ($date<=$today) { //今日以前
                return false;
            }
            return true;
        });
    }
}
