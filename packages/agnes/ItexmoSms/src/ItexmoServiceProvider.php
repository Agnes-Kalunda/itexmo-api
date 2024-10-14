<?php

namespace Agnes\ItexmoSms;

use Illuminate\Support\ServiceProvider;

class ItexmoServiceProvider extends ServiceProvider
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

        $this->app->singleton('itexmo', function ($app) {
            return new ItexmoSms($app['config']['itexmo']);
        });
    }
}