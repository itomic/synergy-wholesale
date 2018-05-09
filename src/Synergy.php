<?php

namespace Itomic\Synergy;

use Itomic\Synergy\SynergyWholesale;

class Synergy
{
    private $synergyWholesale;
    private $lastError;
    
    /**
     * Create a new instance
     * 
     * @param SynergyWholesale $synergyWholesale
     */
    public function __construct(SynergyWholesale $synergyWholesale) {
        $this->synergyWholesale = $synergyWholesale;
    }
    
    /**
     * Synergy-Wholesale API Proxy
     * 
     * Wrapper for Synergy-Wholesale API calls
     * 
     * @param string $command API Command
     * @param array  $data    payload
     * 
     * @return mixed
     */
    private function callApi($command,$data = array())
    {   
        $result = $this->synergyWholesale->$command($data);
        
        if($result) {
            return $result;
        }
        else {
            $this->lastError = $this->synergyWholesale->getApiLastError();
            return false;
        }
    }
    
    /**
     * Domain Information Query
     * 
     * allows you to obtain information for a domain name
     * 
     * @param string $domain_name
     * 
     * @return array
     */
    public function domainInfo($domain_name)
    {
        return $this->callApi('domainInfo',array('domainName' => $domain_name));
    }
    
    /**
     * Account Balance Query
     * 
     * allows you to obtain the account balance
     * 
     * return mixed
     */
    public function balanceQuery()
    {
        return $this->callApi('balanceQuery');
    }
    
    /**
     * Password Update
     * 
     * allows you to update the password of a domain name
     * 
     * @param string $domain_name
     * @param string $new_password
     * 
     * return mixed
     */
    public function updateDomainPassword($domain_name,$new_password)
    {
        return $this->callApi('updateDomainPassword',array('domainName' => $domain_name, 'newPassword' => $new_password));
    }
    
    /**
     * List Domains
     * 
     * return list domains
     * 
     * @param string $status
     * 
     * @return array
     */
    public function listDomains($status=NULL)
    {
        if (is_null($status)) {
            $api = $this->callApi('listDomains');
        } else {
            $api = $this->callApi('listDomains',array('status' => $status));
        }
        return $api;
    }
    
    /**
     * @return \Itomic\Synergy\Synergy
     */
    public function getApi()
    {
        return $this->synergyWholesale;
    }
    
    /**
     * Last API Call Error
     * 
     * wrapper for SynergyWholesale->getError()
     * 
     * return object
     */
    public function getLastError()
    {
        return $this->lastError;
    }
}
