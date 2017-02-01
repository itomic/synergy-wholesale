<?php

namespace Tests\Unit;
use Mockery;
use Tests\TestCase;
use Itomic\Synergy\Synergy;
use Itomic\Synergy\SynergyWholesale;

class SynergyTest extends TestCase
{
    /** @var Mockery\Mock */
    protected $synergyWholesaleApi;
    
    /** @var Itomic\Synergy\Synergy */
    protected $synergy;
    
    public function setUp()
    {
        parent::setUp();
        
        $resellerId = config('synergy-wholesale.resellerID');
        $apiKey = config('synergy-wholesale.apiKey');
        
        $this->synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array($resellerId,$apiKey))
                ->setMethods(['balanceQuery','domainInfo'])
                ->getMock();
        
        $this->synergyWholesaleApi->shouldReceive('getApiLastError');
        
        $this->synergy = new Synergy($this->synergyWholesaleApi);
    }
    
    public function tearDown() {
        
        Mockery::close();
        
        parent::tearDown();
        
    }
    
    /**
     * @test
     */
    public function testBalanceQueryReturnsFalse()
    {
        /*
        $synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array($resellerId,null))
                ->setMethods(['balanceQuery'])
                ->getMock();
        
        $balance = $this->synergy->balanceQuery();
        dd($balance);
        //$stub = $this->createMock(SynergyWholesale::class);
        
        //$stub->method('doSomething')
        //        ->willReturn('foo');
        /*
        $this->synergyWholesaleApi
                ->expects($this->once())
                ->method('__call')
                ->willReturn('123');
        */
        
    }
    
    /**
     * @test
     */
    public function testBalanceQueryReturnsBalance()
    {
        //$stub = $this->createMock(SynergyWholesale::class);
        
        //$stub->method('doSomething')
        //        ->willReturn('foo');
        
        // Create a mock for the Observer class,
        // only mock the update() method.
        
    }
    
}
