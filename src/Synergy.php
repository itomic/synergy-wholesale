<?php

namespace Itomic\Synergy;

class Synergy
{
    const API_LOCATION = 'https://api.synergywholesale.com';
    
    private $location = self::API_LOCATION.'?wsdl';    
    private $resellerId;
    private $apiKey;
    private $lastError;
    
    
    /**
     * Create a new instance
     * 
     * @param string $reseller_id Synergy reseller ID
     * @param string $api_key Synergy API key
     */
    public function __construct($reseller_id,$api_key) {
        $this->resellerId = $reseller_id;
        $this->apiKey = $api_key;
    }
    
    /**
     * Last API Call Error
     * 
     * allows you to retrieve error from last API call
     * 
     * return object
     */
    public function getLastError()
    {
        return $this->lastError;
    }
    
    /**
     * Synergy-Wholesale API Proxy
     * 
     * Wrapper for Synergy-Wholesale API calls
     * 
     * @param string $command API Command
     * @param array $data payload
     * 
     * return mixed
     */
    private function callApi($command,$data = array())
    {
        try {
            // New soap connection
            $client = new SoapClient(null, array('location' => $this->location,'uri' => ""));

            // make API call
            $output = $client->$command(array_merge(array('resellerID' => $this->resellerId, 'apiKey' => $this->apiKey), $data));
            
            return $output;

        } catch (SoapFault $fault) {
            
            $this->lastError = $fault;
            
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
     * return array
     */
    public function domainInfo($domain_name)
    {
        return $this->callApi('domainInfo', array('domainName' => $domain_name));
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
     * @return \Itomic\Synergy\Synergy
     */
    public function getApi()
    {
        return $this;
    }
    
    /**
     * Availability
     * 
     * allows you to check the availability of a domain name
     * 
     * @param string $domain_name
     * 
     * return array
     */
    public function checkDomain($domain_name)
    {
        return $this->callApi('checkDomain',array('domainName' => $domain_name));
    }
}
