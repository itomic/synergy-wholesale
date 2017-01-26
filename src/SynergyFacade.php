<?php

namespace Itomic\Synergy;

use Illuminate\Support\Facades\Facade;

class SynergyFacade extends Facade {
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'synergy';
    }
}