<?php

namespace JornSchalkwijk\LaravelCMS;

use Illuminate\Support\ServiceProvider;

class LaravelCMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'JornSchalkwijk\LaravelCMS');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
