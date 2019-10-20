<?php

namespace AfriCC\EPP\Extension\NASK\Update;

use AfriCC\EPP\Frame\Command\Update as UpdateCommand;
use AfriCC\EPP\Random;
use AfriCC\EPP\Validator;
use Exception;

class Future extends UpdateCommand
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
     * Change registrant contact id of Future object
     *
     * @param string $registrant ContactID of registrant
     */
    public function changeRegistrant($registrant)
    {
        $this->set('future:chg/future:registrant', $registrant);
    }

    /**
     * Change future AuthInfo, generate if passed null
     *
     * @param string $pw AuthInfo code
     *
     * @return string  AuthInfo code
     */
    public function changeAuthInfo($pw = null)
    {
        if ($pw === null) {
            $pw = Random::auth(12);
        }

        $this->set('future:chg/future:authInfo/future:pw', $pw);

        return $pw;
    }
}
