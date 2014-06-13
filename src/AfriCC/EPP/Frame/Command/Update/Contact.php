<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Update;

use AfriCC\EPP\Frame\Command\Update as UpdateCommand;
use AfriCC\EPP\ContactTrait;

/**
 * @link http://tools.ietf.org/html/rfc5733#section-3.2.5
 */
class Contact extends UpdateCommand
{
    use ContactTrait;

    public function setId($id)
    {
        $this->appendId('contact:id', $id);
    }

    private function setName($mode, $name)
    {
        $this->appendName(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:name', $mode), $name);
    }

    private function setOrganization($mode, $org)
    {
        $this->appendOrganization(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:org', $mode), $org);
    }

    private function addStreet($mode, $street)
    {
        $this->appendStreet(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:street[]', $mode), $street);
    }

    private function setCity($mode, $city)
    {
        $this->appendCity(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:city', $mode), $city);
    }

    private function setProvince($mode, $sp)
    {
        $this->appendProvince(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:sp', $mode), $sp);
    }

    private function setPostalCode($mode, $pc)
    {
        $this->appendPostalCode(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:pc', $mode), $pc);
    }

    private function setCountryCode($mode, $cc)
    {
        $this->appendCountryCode(sprintf('contact:%s/contact:postalInfo[@type=\'%%s\']/contact:addr/contact:cc', $mode), $cc);
    }

    private function setVoice($mode, $voice)
    {
        $this->appendVoice(sprintf('contact:%s/contact:voice', $mode), $voice);
    }

    private function setFax($mode, $fax)
    {
        $this->appendFax(sprintf('contact:%s/contact:fax', $mode), $fax);
    }

    private function setEmail($mode, $email)
    {
        $this->appendEmail(sprintf('contact:%s/contact:email', $mode), $email);
    }

    private function setAuthInfo($mode, $pw = null)
    {
        return $this->appendAuthInfo(sprintf('contact:%s/contact:authInfo/contact:pw', $mode), $pw);
    }

    private function addDisclose($mode, $value)
    {
        $this->appendDisclose(sprintf('contact:%s/contact:disclose[@flag=\'0\']/contact:' . $value, $mode));
    }

    public function __call($name, $arguments)
    {
        if (strpos($name, 'add') === 0) {
            array_unshift($arguments, 'add');
            $method_name = substr($name, 3);
        } elseif (strpos($name, 'remove') === 0) {
            array_unshift($arguments, 'rem');
            $method_name = substr($name, 6);
        } elseif (strpos($name, 'change') === 0) {
            array_unshift($arguments, 'chg');
            $method_name = substr($name, 6);
        } else {
            return;
        }

        if (strpos($method_name, 'Add') === 0) {
            $method_name = lcfirst($method_name);
        } else {
            $method_name = 'set' . $method_name;
        }

        if (is_callable(array($this, $method_name))) {
            return call_user_func_array(array($this, $method_name), $arguments);
        }
    }
}
