<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorTextServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('text', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value)) {
                return false;
            }
            if (!preg_match("/^[ぁ-んァ-ン一-龥a-zA-Z0-9 -\/:-@\[-`\{-\~]+$/", $value)) {
                return false;
            }
            return true;
        });
    }
}
