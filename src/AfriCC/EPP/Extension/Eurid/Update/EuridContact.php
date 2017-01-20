<?php
namespace AfriCC\EPP\Extension\Eurid\Update;

use AfriCC\EPP\Frame\Command\Update\Contact as ContactUpdate;
use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\ObjectSpec;


class EuridContact extends ContactUpdate implements Extension
{
    protected $extension_xmlns = 'http://www.eurid.eu/xml/epp/contact-ext-1.1';


    public function setName($mode, $name)
    {
        $this->appendName(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:name', $mode), $name);
    }

    public function setOrganization($mode, $org)
    {
        $this->appendOrganization(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:org', $mode), $org);
    }

    public function addStreet($mode, $street)
    {
        $this->appendStreet(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:street[]', $mode), $street);
    }

    public function setCity($mode, $city)
    {
        $this->appendCity(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:city', $mode), $city);
    }

    public function setProvince($mode, $sp)
    {
        $this->appendProvince(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:sp', $mode), $sp);
    }

    public function setPostalCode($mode, $pc)
    {
        $this->appendPostalCode(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:pc', $mode), $pc);
    }

    public function setCountryCode($mode, $cc)
    {
        $this->appendCountryCode(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:cc', $mode), $cc);
    }

    public function setVoice($mode, $voice)
    {
        $this->appendVoice(sprintf('contact:%s/contact:voice', $mode), $voice);
    }

    public function setFax($mode, $fax)
    {
        $this->appendFax(sprintf('contact:%s/contact:fax', $mode), $fax);
    }

    public function setEmail($mode, $email)
    {
        $this->appendEmail(sprintf('contact:%s/contact:email', $mode), $email);
    }

    public function setAuthInfo($mode, $pw = null)
    {
        return $this->appendAuthInfo(sprintf('contact:%s/contact:authInfo/contact:pw', $mode), $pw);
    }

    public function addDisclose($mode, $value, $flag = 0)
    {
        $this->appendDisclose(sprintf('contact:%s/contact:disclose[@flag=\'%d\']/contact:%s', $mode, $flag, $value));
    }
    
    public function euridSetChd()
    {
        ObjectSpec::$specs += [
            'contact-ext' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        $this->set("//epp:epp/epp:command/epp:extension/contact-ext:update/contact-ext:chg");
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}
