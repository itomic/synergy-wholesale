<?php

namespace Itomic\Synergy;

use Itomic\Synergy\SynergyWholesale;

class Synergy
{
    private $synergyWholesale;
    
    /**
     * Create a new instance
     * 
     * @param SynergyWholesale $synergyWholesale
     */
    public function __construct(SynergyWholesale $synergyWholesale) {
        $this->synergyWholesale = $synergyWholesale;
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
        return $this->synergyWholesale->domainInfo(array('domainName' => $domain_name));
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
        return $this->synergyWholesale->balanceQuery();
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
        return $this->synergyWholesale->updateDomainPassword(array('domainName' => $domain_name, 'newPassword' => $new_password));
    }
    
    /**
     * @return \Itomic\Synergy\Synergy
     */
    public function getApi()
    {
        return $this->synergyWholesale;
    }
}
