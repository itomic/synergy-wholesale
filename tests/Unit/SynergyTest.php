<?php

namespace Tests\Unit;
use Mockery;
use Tests\TestCase;
use Itomic\Synergy\Synergy;
use Itomic\Synergy\SynergyWholesale;

class SynergyTest extends TestCase
{
    /** @var Mockery\Mock */
    private $synergyWholesaleApi;
    
    /** @var Itomic\Synergy\Synergy */
    private $synergy;
    
    public function setUp() {
        parent::setUp();
        
        $this->synergyWholesaleApi = $this->getMockBuilder(SynergyWholesale::class)
                ->setConstructorArgs(array(config('synergy-wholesale.resellerID'),config('synergy-wholesale.apiKey')))
                ->setMethods(['balanceQuery','domainInfo','getApiLastError'])
                ->getMock();
        
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
        $this->synergyWholesaleApi
                ->expects($this->once())
                ->method('balanceQuery')
                ->willReturn(false);
        
        $this->synergyWholesaleApi
                ->expects($this->any())
                ->method('getApiLastError')
                ->willReturn((object) array('status'=>'ERR_LOGIN_FAILED','errorMessage'=>'Unable to login to wholesale system'));
        
        $balance = $this->synergy->balanceQuery();
        if(!$balance) {
            $error = $this->synergy->getLastError();
            print_r($error);
        }
    }
    
    /**
     * @test
     */
    public function testBalanceQueryReturnsBalance()
    {
        $this->synergyWholesaleApi
                ->expects($this->once())
                ->method('balanceQuery')
                ->willReturn((object) array('status'=>'OK','balance'=>802.25));
        
        $balance = $this->synergy->balanceQuery();
        if($balance) {
            print_r($balance);
        }
    }
    
    /**
     * @test
     */
    public function testDomainInfoReturnsFalse()
    {
        $domain = 'nonexistentdomain.com.au';
        
        $this->synergyWholesaleApi
                ->expects($this->once())
                ->method('domainInfo')
                ->willReturn(false);
        
        $this->synergyWholesaleApi
                ->expects($this->any())
                ->method('getApiLastError')
                ->willReturn((object) array(
                    'status' => 'ERR_DOMAININFO_FAILED',
                    'errorMessage' => 'Domain Info Failed - Domain Does Not Exist',
                    'domainName' => $domain,
                    'domain_status' => 'Domain does not exist'
                ));
        
        $domainInfo = $this->synergy->domainInfo($domain);
        if(!$domainInfo) {
            $error = $this->synergy->getLastError();
            print_r($error);
        }
    }
    
    /**
     * @test
     */
    public function testDomainInfoReturnsSuccess()
    {
        $domain = 'synergywholesale.com';
        
        $this->synergyWholesaleApi
                ->expects($this->once())
                ->method('domainInfo')
                ->willReturn((object) array(
                    'domainName' => $domain,
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
        
        $domainInfo = $this->synergy->domainInfo($domain);
        if($domainInfo) {
            print_r($domainInfo);
        }
    }
    
}
