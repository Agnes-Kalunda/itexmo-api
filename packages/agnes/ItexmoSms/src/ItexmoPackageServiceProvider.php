<?php

namespace Agnes\ItexmoSms;

use Illuminate\Support\ServiceProvider;

class ItexmoSmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/itexmo.php' => config_path('itexmo.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/itexmo.php', 'itexmo'
        );

        $this->app->singleton(ItexmoSms::class, function ($app) {
            return new ItexmoSms();
        });
    }
}