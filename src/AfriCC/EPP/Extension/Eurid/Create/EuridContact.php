<?php
namespace AfriCC\EPP\Extension\Eurid\Create;

use AfriCC\EPP\Frame\Command\Create\Contact as ContactCreate;
use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\ObjectSpec;


class EuridContact extends ContactCreate implements Extension
{
    protected $extension_xmlns = 'http://www.eurid.eu/xml/epp/contact-ext-1.1';

    public function setEuridContactType($type)
    {
        ObjectSpec::$specs += [
            'contact-ext' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        $this->set("//epp:epp/epp:command/epp:extension/contact-ext:create/contact-ext:type", $type);
    }

    public function setEuridContactLang($lang)
    {
        ObjectSpec::$specs += [
            'contact-ext' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        $this->set("//epp:epp/epp:command/epp:extension/contact-ext:create/contact-ext:lang", $lang);
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}
