<?php

namespace AfriCC\EPP\Extension\NASK\Create;

use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Create\Contact as ContactCreate;

class Contact extends ContactCreate implements ExtensionInterface
{
    protected $extension = 'extcon';
    protected $extension_xmlns = 'http://www.dns.pl/nask-epp-schema/extcon-2.0';

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }

    /**
     * Set entity type of contact
     *
     * @param bool $individual True if person, false if company
     */
    public function setIndividual($individual = false)
    {
        $this->set('//epp:epp/epp:command/epp:extension/extcon:create/extcon:individual', $individual ? 1 : 0);
    }

    /**
     * Set consent for publishing
     *
     * Don't use
     *
     * Ignored since 6.1.19
     * Up until 6.1.19 this HAD to be true if Individual was to be False
     *
     * @deprecated Since NASK registry 6.1.19, removed in registry 6.2.1
     *
     * @param bool $consent
     */
    public function setConsentForPublishing($consent = false)
    {
        $this->set('//epp:epp/epp:command/epp:extension/extcon:create/extcon:consentForPublishing', $consent ? 1 : 0);
    }
}
