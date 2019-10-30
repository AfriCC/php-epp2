<?php

namespace AfriCC\EPP\Extension\NASK\Info;

use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Info\Contact as ContactInfo;

class Contact extends ContactInfo implements ExtensionInterface
{
    protected $extension = 'extcon';
    protected $extension_xmlns = 'http://www.dns.pl/nask-epp-schema/extcon-2.0';

    /**
     * Set contact authinfo
     *
     * @param string $pw authinfo
     * @param string $roid If specified, authinfo is of domain whose registrant is this contact
     */
    public function setAuthInfo($pw, $roid = null)
    {
        $node = $this->set('//epp:epp/epp:command/epp:extension/extcon:info/extcon:authInfo/extcon:pw', $pw);

        if ($roid !== null) {
            $node->setAttribute('roid', $roid);
        }
    }
}
