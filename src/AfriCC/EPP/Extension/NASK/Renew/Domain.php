<?php

namespace AfriCC\EPP\Extension\NASK\Renew;

use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Renew\Domain as DomainRenew;

class Domain extends DomainRenew implements ExtensionInterface
{
    protected $extension = 'extdom';
    protected $extension_xmlns = 'http://www.dns.pl/nask-epp-schema/extdom-2.0';

    public function setReactivate()
    {
        $this->set('//epp:epp/epp:command/epp:extension/extdom:renew/extdom:reactivate');
    }

    public function setRenewToDate($date)
    {
        $this->set('//epp:epp/epp:command/epp:extension/extdom:renew/extdom:renewToDate', $date);
    }
}
