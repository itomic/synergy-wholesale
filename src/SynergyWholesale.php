<?php

namespace Itomic\Synergy;

use SoapClient;
use SoapFault;

class SynergyWholesale
{
    const API_LOCATION = 'https://api.synergywholesale.com';
    
    private $location = self::API_LOCATION.'?wsdl';    
    private $resellerId;
    private $apiKey;
    private $apiLastError = false;
    
    
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
    public function getApiLastError()
    {
        return $this->apiLastError;
    }
    
    /**
     * Synergy-Wholesale interpreter hook
     * 
     * Wrapper for Synergy-Wholesale API calls
     * 
     * @param string $command API Command
     * @param array  $data    payload
     * 
     * @return mixed
     */
    public function __call($command,$data)
    {
        try {
            // New soap connection
            $client = new SoapClient(null, array('location' => $this->location, 'uri' => ""));
            
            // make API call
            $output = $client->$command(array_merge(array('resellerID' => $this->resellerId, 'apiKey' => $this->apiKey), $data));
            
            return $output;

        } catch (SoapFault $fault) {
            
            $this->apiLastError = new SoapFault($fault->faultcode,$fault->faultstring);
            
            return false;
        }
    }
}
