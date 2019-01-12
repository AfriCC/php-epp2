<?php

namespace AfriCC\EPP\Extension\NASK\Delete;

use AfriCC\EPP\Frame\Command\Delete as DeleteCommand;
use AfriCC\EPP\Validator;
use Exception;

class Future extends DeleteCommand
{
    /**
     * Set domain name for future (option)
     *
     * @param string $domain Domain Name
     *
     * @throws Exception on incorrect domain name
     */
    public function setFuture($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }

        $this->set('future:name', $domain);
    }
}
