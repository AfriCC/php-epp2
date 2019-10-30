<?php

namespace AfriCC\EPP\Extension\NASK\Create;

use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Create\Domain as DomainCreate;
use AfriCC\EPP\Validator;

class Domain extends DomainCreate implements ExtensionInterface
{
    protected $extension = 'extdom';
    protected $extension_xmlns = 'http://www.dns.pl/nask-epp-schema/extdom-2.0';

    public function setBook()
    {
        $this->set('//epp:epp/epp:command/epp:extension/extdom:create/extdom:book');
    }

    public function addNs($host)
    {
        if (!Validator::isHostname($host)) {
            throw new \Exception(sprintf('%s is not a valid host name', $host));
        }

        $this->set('domain:ns[]', $host);
    }

    public function addHostObj($host)
    {
        return $this->addNs($host);
    }

    public function setAdminContact($admin_contact)
    {
        return false; //TODO: should this throw if registry doesn't allow Admin contact?
    }

    public function setTechContact($tech_contact)
    {
        return false; //TODO: should this throw if registry doesn't allow Tech contact?
    }

    public function setBillingContact($billing_contact)
    {
        return false; //TODO: should this throw if registry doesn't allow Billing contact?
    }
}
