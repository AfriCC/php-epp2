<?php

namespace AfriCC\EPP\Extension\NASK\Create;

use AfriCC\EPP\Frame\Command\Create as CreateCommand;
use AfriCC\EPP\PeriodTrait;
use AfriCC\EPP\Random;
use AfriCC\EPP\Validator;
use Exception;

class Future extends CreateCommand
{
    use PeriodTrait;

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
     * Set future period
     *
     * Set period for which to create Future. Usually that will be 3y
     *
     * @param string $period Period ending with with y or m
     */
    public function setPeriod($period)
    {
        $this->appendPeriod('future:period[@unit=\'%s\']', $period);
    }

    /**
     * Set future registrant
     *
     * @param string $registrant registrant ContactID
     */
    public function setRegistrant($registrant)
    {
        $this->set('future:registrant', $registrant);
    }

    /**
     * Set future AuthInfo, generate if passed null
     *
     * @param string $pw AuthInfo code
     *
     * @return string  AuthInfo code
     */
    public function setAuthInfo($pw = null)
    {
        if ($pw === null) {
            $pw = Random::auth(12);
        }

        $this->set('future:authInfo/future:pw', $pw);

        return $pw;
    }
}
