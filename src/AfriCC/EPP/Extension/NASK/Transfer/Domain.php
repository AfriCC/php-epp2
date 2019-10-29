<?php

namespace AfriCC\EPP\Extension\NASK\Transfer;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Transfer\Domain as DomainTransfer;

class Domain extends DomainTransfer implements Extension
{
    protected $extension = 'extdom';
    protected $extension_xmlns = 'http://www.dns.pl/nask-epp-schema/extdom-2.0';

    /**
     * Add resend confirmation request
     *
     * This element can only be applied on request frame with no period specified
     */
    public function resendConfirmationRequest()
    {
        $this->set('//epp:epp/epp:command/epp:extension/extdom:transfer/extdom:resendConfirmationRequest');
    }
}
