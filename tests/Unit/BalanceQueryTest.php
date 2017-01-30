<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;

use Itomic\Synergy\Synergy;

class BalanceQueryTest extends TestCase
{
    
    /**
     * Package Configuration
     *
     * @return void
     */
    public function testConfig() {
        
        $this->assertEquals(env('SW_RESELLER_ID'),config('synergy-wholesale.resellerID'));
        
        $this->assertEquals(env('SW_APIKEY'),config('synergy-wholesale.apiKey'));
        
    }
    
    /**
     * Failed Account Balance
     *
     * @return void
     */
    public function testFailedAccountBalance()
    {
        $synergyApi = new Synergy(null,null);
        
        $balance = $synergyApi::balanceQuery();
        
        $this->assertEquals(false,$balance);
    }
}
