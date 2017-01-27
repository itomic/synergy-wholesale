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
        /** load configuration */
        $this->mergeConfigFrom(__DIR__.'/../config/synergy-wholesale.php', 'synergy-wholesale');
        
        
        /** publishes() is not necessary, I think(?) - at least at this point of the development process. */
        
        /*
        $this->publishes([
            __DIR__.'../config/synergy-wholesale.php' => config_path('synergy-wholesale.php'),
        ],'config');
        */
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Synergy::class, function () {
            return new Synergy(config('synergy-wholesale.resellerID'),config('synergy-wholesale.apiKey'));
        });
        
        $this->app->alias(Synergy::class, 'synergy');
        
    }
}
