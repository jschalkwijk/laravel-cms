<?php

namespace JornSchalkwijk\LaravelCMS;

use Illuminate\Http\Request;
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

        $this->publishes([
            __DIR__.'/public/assets' => public_path('vendor/jornschalkwijk/LaravelCMS'),
        ], 'public');

        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            __DIR__.'/database/seeds/' => database_path('seeds')
        ], 'migrations');
        $this->publishes([
            __DIR__.'/database/factories/' => database_path('factories')
        ], 'migrations');
        $this->publishes([
            __DIR__.'/database/mysql/' => database_path('mysql')
        ], 'migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // bind the interface to the class that needs to be used
        $this->app->bind(
            'JornSchalkwijk\LaravelCMS\Models\Support\StorageInterface',
            'JornSchalkwijk\LaravelCMS\Models\Support\SessionStorage'
        );
    }
}
