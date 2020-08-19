<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorKatakanaServiceProvider extends ServiceProvider
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
        Validator::extend('katakana', function ($attribute, $value, $parameters, $validator) {
            if (!is_string($value)) {
                return false;
            }
            if (!preg_match("/^([ァ-ン]|ー)+$/", $value)) {
                return false;
            }
            return true;
        });
    }
}
