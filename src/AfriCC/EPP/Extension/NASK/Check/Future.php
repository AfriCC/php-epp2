<?php

namespace AfriCC\EPP\Extension\NASK\Check;

use AfriCC\EPP\Frame\Command\Check as CheckCommand;
use AfriCC\EPP\Validator;
use Exception;

class Future extends CheckCommand
{
    /**
     * Add future (option for domain)
     *
     * @param string $domain Domain name
     *
     * @throws Exception Upon incorrect domain name
     */
    public function addFuture($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }
        $this->set('future:name[]', $domain);
    }
}
