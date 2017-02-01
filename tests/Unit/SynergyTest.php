<?php

namespace Tests\Unit;
use Mockery;
use Tests\TestCase;
use Itomic\Synergy\Synergy;
use Itomic\Synergy\SynergyWholesale;

class SynergyTest extends TestCase
{
    public function tearDown() {
        
        Mockery::close();
        
        parent::tearDown();
        
    }
    
    /**
     * @test
     */
    public function testBalanceQueryReturnsFalse()
    {
        $synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array(config('synergy-wholesale.resellerID'),config('synergy-wholesale.apiKey')))
                ->setMethods(['balanceQuery'])
                ->getMock();
        $synergy = new Synergy($synergyWholesaleApi);
        
        $synergyWholesaleApi->expects($this->once())->method('balanceQuery');
        
        $synergy->balanceQuery();
    }
    
    /**
     * @test
     */
    public function testBalanceQueryReturnsBalance()
    {
        $synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array(config('synergy-wholesale.resellerID'),config('synergy-wholesale.apiKey')))
                ->setMethods(['balanceQuery'])
                ->getMock();
        
        $synergy = new Synergy($synergyWholesaleApi);
        
        $synergyWholesaleApi->expects($this->once())->method('balanceQuery');
        
        $synergy->balanceQuery();
    }
    
    /**
     * @test
     */
    public function testDomainInfoReturnsFalse()
    {
        $synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array(config('synergy-wholesale.resellerID'),config('synergy-wholesale.apiKey')))
                ->setMethods(['domainInfo'])
                ->getMock();
        
        $synergy = new Synergy($synergyWholesaleApi);
        
        $synergyWholesaleApi->expects($this->once())->method('domainInfo');
        
        $synergy->domainInfo('testdomain');
    }
    
    /**
     * @test
     */
    public function testDomainInfoReturnsSuccess()
    {
        $synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array(config('synergy-wholesale.resellerID'),config('synergy-wholesale.apiKey')))
                ->setMethods(['domainInfo'])
                ->getMock();
        
        $synergy = new Synergy($synergyWholesaleApi);
        
        $synergyWholesaleApi->expects($this->once())->method('domainInfo');
        
        $synergy->domainInfo('testdomain');
    }
    
}
