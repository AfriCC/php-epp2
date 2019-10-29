<?php

namespace AfriCC\EPP\Extension\NASK\Update;

use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Update\Domain as DomainUpdate;
use AfriCC\EPP\Validator;

class Domain extends DomainUpdate implements ExtensionInterface
{
    protected $extension = 'extdom';
    protected $extension_xmlns = 'http://www.dns.pl/nask-epp-schema/extdom-2.0';

    public function addNs($host, $remove = false)
    {
        if (!Validator::isHostname($host)) {
            throw new \Exception(sprintf('%s is not a valid host name', $host));
        }

        if ($remove) {
            $key = 'rem';
        } else {
            $key = 'add';
        }

        $this->set(sprintf('domain:%s/domain:ns[]', $key), $host);
    }

    public function removeNs($host)
    {
        return $this->addNs($host, true);
    }

    public function addHostObj($host, $remove = false)
    {
        return $this->addNs($host, $remove);
    }

    public function addAdminContact($contact, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            return false; //TODO: should this thow if registry forbids adding Admin contact?
        }

        $this->set(sprintf('domain:%s/domain:contact[@type=\'admin\']', $key), $contact);
    }

    public function addTechContact($contact, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            return false; //TODO: shuld this throw if registry forbids adding Tech contact?
        }

        $this->set(sprintf('domain:%s/domain:contact[@type=\'tech\']', $key), $contact);
    }

    public function addBillingContact($contact, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            return false; //TODO: should this throw if registry forbids adding Billing contact
        }

        $this->set(sprintf('domain:%s/domain:contact[@type=\'billing\']', $key), $contact);
    }
}
