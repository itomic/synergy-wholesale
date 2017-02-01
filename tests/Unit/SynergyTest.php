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
                ->setMethods(['balanceQuery','getApiLastError'])
                ->getMock();
        
        $synergy = new Synergy($synergyWholesaleApi);
        
        $synergyWholesaleApi
                ->expects($this->once())
                ->method('balanceQuery')
                ->willReturn(false);
        
        $synergyWholesaleApi
                ->expects($this->any())
                ->method('getApiLastError')
                ->willReturn((object) array('status'=>'ERR_LOGIN_FAILED','errorMessage'=>'Unable to login to wholesale system'));
        
        $balance = $synergy->balanceQuery();
        if(!$balance) {
            $error = $synergy->getLastError();
            print_r($error);
        }
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
        
        $synergyWholesaleApi
                ->expects($this->once())
                ->method('balanceQuery')
                ->willReturn((object) array('status'=>'OK','balance'=>802.25));
        
        $balance = $synergy->balanceQuery();
        if($balance) {
            print_r($balance);
        }
    }
    
    /**
     * @test
     */
    public function testDomainInfoReturnsFalse()
    {
        $synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array(config('synergy-wholesale.resellerID'),config('synergy-wholesale.apiKey')))
                ->setMethods(['domainInfo','getApiLastError'])
                ->getMock();
        
        $synergy = new Synergy($synergyWholesaleApi);
        
        $synergyWholesaleApi
                ->expects($this->once())
                ->method('domainInfo')
                ->willReturn(false);
        
        $synergyWholesaleApi
                ->expects($this->any())
                ->method('getApiLastError')
                ->willReturn((object) array(
                    'status' => 'ERR_DOMAININFO_FAILED',
                    'errorMessage' => 'Domain Info Failed - Domain Does Not Exist',
                    'domainName' => 'nonexistentdomain.com.au',
                    'domain_status' => 'Domain does not exist'
                ));
        
        $domainInfo = $synergy->domainInfo('nonexistentdomain.com.au');
        if(!$domainInfo) {
            $error = $synergy->getLastError();
            print_r($error);
        }
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
        
        $synergyWholesaleApi
                ->expects($this->once())
                ->method('domainInfo')
                ->willReturn((object) array(
                    'domainName' => 'synergywholesale.com',
                    'domain_status' => 'clientTransferProhibited',
                    'domain_expiry' => '2022-01-17 16:31:47',
                    'nameServers' => array (
                        '0' => 'NS1.HOST-SERVICES.US',
                        '1' => 'NS2.HOST-SERVICES.US'
                    ),
                    'dnsConfig' => 1,
                    'dnsConfigName' => 'Custom',
                    'bulkInProgress' => 0,
                    'domainPassword' => '**********',
                    'status' => 'OK',
                    'idProtect' => 'Disabled',
                    'autoRenew' => 'off',
                    'icannVerificationDateEnd' => '2014-05-31 23:59:59',
                    'icannStatus' => 'Pending Verification',
                    'DSData' => array (
                        'keyTag' => 9885,
                        'Algoirthm' => 5,
                        'Digest' => '476XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
                        'DigestType' => 1,
                        'UUID' => '87xxx5xxx4',
                    )
                ));
        
        $domainInfo = $synergy->domainInfo('synergywholesale.com');
        if($domainInfo) {
            print_r($domainInfo);
        }
    }
    
}
