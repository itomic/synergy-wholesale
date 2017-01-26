<?php

namespace Itomic\Synergy;

use Illuminate\Support\ServiceProvider;

class SynergyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->publishes([
            __DIR__.'../config/synergy-wholesale.php' => config_path('synergy-wholesale.php'),
        ],'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        /*
        $this->app->singleton(Synergy::class, function () {
            return new Synergy();
        });
        
        $this->app->alias(Synergy::class, 'synergy');
        */
        \App::bind('synergy', function()
        {
            return new Synergy;
        });
    }
}
