<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Create;

use AfriCC\EPP\ContactTrait;
use AfriCC\EPP\Frame\Command\Create;

/**
 * @see http://tools.ietf.org/html/rfc5733#section-3.2.1
 */
class Contact extends Create
{
    use ContactTrait;

    public function setId($id)
    {
        $this->appendId('contact:id', $id);
    }

    public function setName($name)
    {
        $this->appendName('contact:postalInfo[@type=\'%s\']/contact:name', $name);
    }

    public function setOrganization($org)
    {
        $this->appendOrganization('contact:postalInfo[@type=\'%s\']/contact:org', $org);
    }

    public function addStreet($street)
    {
        $this->appendStreet('contact:postalInfo[@type=\'%s\']/contact:addr/contact:street[]', $street);
    }

    public function setCity($city)
    {
        $this->appendCity('contact:postalInfo[@type=\'%s\']/contact:addr/contact:city', $city);
    }

    public function setProvince($sp)
    {
        $this->appendProvince('contact:postalInfo[@type=\'%s\']/contact:addr/contact:sp', $sp);
    }

    public function setPostalCode($pc)
    {
        $this->appendPostalCode('contact:postalInfo[@type=\'%s\']/contact:addr/contact:pc', $pc);
    }

    public function setCountryCode($cc)
    {
        $this->appendCountryCode('contact:postalInfo[@type=\'%s\']/contact:addr/contact:cc', $cc);
    }

    public function setVoice($voice, $extension = null)
    {
        $this->appendVoice('contact:voice', $voice, $extension);
    }

    public function setFax($fax, $extension = null)
    {
        $this->appendFax('contact:fax', $fax, $extension);
    }

    public function setEmail($email)
    {
        $this->appendEmail('contact:email', $email);
    }

    public function setAuthInfo($pw = null)
    {
        return $this->appendAuthInfo('contact:authInfo/contact:pw', $pw);
    }

    public function addDisclose($value, $flag = 0)
    {
        $this->appendDisclose(sprintf('contact:disclose[@flag=\'%d\']/contact:%s', (int) $flag, $value));
    }
}
