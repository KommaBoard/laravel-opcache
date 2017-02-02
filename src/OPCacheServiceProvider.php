<?php

namespace FreWillems\OPCache;

use Illuminate\Support\ServiceProvider;

class OPCacheServiceProvider extends ServiceProvider
{
    protected $cmd = [
        'FreWillems\OPCache\OPCacheCommand'
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->publishes([
            __DIR__ . '/config/opcache.php' => config_path('opcache.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/opcache.php', 'opcache');
        $this->app->make('FreWillems\OPCache\OPCacheController');
        $this->commands($this->cmd);
    }
}
