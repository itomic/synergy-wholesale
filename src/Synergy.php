<?php

namespace Itomic\Synergy;

use SoapClient;
use SoapFault;

class Synergy
{
    const API_LOCATION = 'https://api.synergywholesale.com?wsdl';
    
    private static $location = self::API_LOCATION.'?wsdl';    
    private static $resellerId;
    private static $apiKey;
    private static $lastError;
    
    
    /**
     * Create a new instance
     * 
     * @param string $reseller_id Synergy reseller ID
     * @param string $api_key Synergy API key
     */
    public function __construct($reseller_id,$api_key) {
        self::$resellerId = $reseller_id;
        self::$apiKey = $api_key;
    }
    
    /**
     * Last API Call Error
     * 
     * allows you to retrieve error from last API call
     * 
     * return object
     */
    public static function getLastError()
    {
        return self::$lastError;
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
    private static function callApi($command,$data = array())
    {   
        try {
            // New soap connection
            $client = new SoapClient(null, array('location' => self::$location, 'uri' => ""));
            
            // make API call
            $output = $client->$command(array_merge(array('resellerID' => self::$resellerId, 'apiKey' => self::$apiKey), $data));
            
            return $output;

        } catch (SoapFault $fault) {
            
            self::$lastError = $fault;
            
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
    public static function domainInfo($domain_name)
    {
        return self::callApi('domainInfo', array('domainName' => $domain_name));
    }
    
    /**
     * Account Balance Query
     * 
     * allows you to obtain the account balance
     * 
     * return mixed
     */
    public static function balanceQuery()
    {
        return self::callApi('balanceQuery');
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
    public static function updateDomainPassword($domain_name,$new_password)
    {
        return self::callApi('updateDomainPassword',array('domainName' => $domain_name, 'newPassword' => $new_password));
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
