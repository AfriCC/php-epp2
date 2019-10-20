<?php

namespace AfriCC\EPP\Extension\NASK\Info;

use AfriCC\EPP\Frame\Command\Info as InfoCommand;
use AfriCC\EPP\Validator;
use Exception;

class Future extends InfoCommand
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

    /**
     * Set requested future AuthInfo
     *
     * @param string $pw AuthInfo for future
     * @param string $roid if specified, this is ContactId of registrant and autinfo is of registrant
     */
    public function setAuthInfo($pw, $roid = null)
    {
        $node = $this->set('future:authInfo/future:pw', $pw);

        if ($roid !== null) {
            $node->setAttribute('roid', $roid);
        }
    }
}
