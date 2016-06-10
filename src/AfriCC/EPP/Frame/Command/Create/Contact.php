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

use AfriCC\EPP\Frame\Command\Create as CreateCommand;
use AfriCC\EPP\ContactTrait;

/**
 * @link http://tools.ietf.org/html/rfc5733#section-3.2.1
 */
class Contact extends CreateCommand
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

    public function setVoice($voice)
    {
        $this->appendVoice('contact:voice', $voice);
    }

    public function setFax($fax)
    {
        $this->appendFax('contact:fax', $fax);
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
        $this->appendDisclose(sprintf('contact:disclose[@flag=\'%d\']/contact:%s', (int)$flag, $value));
    }

    /**
     * Expect one of following keys or values.
     * Usage example: setContactRole(2) or setContactRole("admin')
     *
     * $role           -              2 => "admin",
     *                                3 => "reseller",
     *                                4 => "technical_contact",
     *                                5 => "registrant_holder"
     * @param $role
     * @throws \Exception
     */
    public function setContactRole($role)
    {
        $this->appendRole('contact:role', $role);
    }

    /**
     * Expect one of following keys or values.
     * Usage example: setContactType(1) or setContactType("company')
     *
     * $type           -                0 => "private_person",
     *                                  1 => "company",
     *                                  2 => "corporation",
     *                                  3 => "institution",
     *                                  4 => "political_party",
     *                                  5 => "township",
     *                                  6 => "government",
     *                                  7 => "public_community"
     *
     * @param $type
     * @throws \Exception
     */
    public function setContactType($type)
    {
        $this->appendType('contact:type', $type);
    }

    /**
     * For contact role 5, <contact:legalemail> is mandatory, for others <contact:email> is mandatory
     *
     * @param $email
     */
    public function setLegalEmail($email)
    {
        $this->appendLegalEmail('contact:legalemail', $email);
    }

    public function setFirstName($firstName)
    {
        $this->appendFirstName('contact:postalInfo[@type=\'%s\']/contact:firstname', $firstName);
    }

    public function setLastName($lastName)
    {
        $this->appendLastName('contact:postalInfo[@type=\'%s\']/contact:lastname', $lastName);
    }

    public function setRegisterNumber($number)
    {
        $this->appendRegisterNumber('contact:postalInfo[@type=\'%s\']/contact:registernumber', $number);
    }

    public function setGender($gender)
    {
        $this->appendGender('contact:postalInfo[@type=\'%s\']/contact:gender', $gender);
    }

    public function setIsFinish($finish)
    {
        $this->appendIsFinish('contact:postalInfo[@type=\'%s\']/contact:isfinnish', $finish);
    }

    /**
     *  $frame->setIdentity('123423A123F');
     * $frame->birthDate('2005-04-03T22:00:00.0Z');
     */
    public function setIdentity($identity)
    {
        $this->appendIdentity('contact:postalInfo[@type=\'%s\']/contact:identity', $identity);
    }

    public function setBirthDate($date)
    {
        $this->appendBirthDay('contact:postalInfo[@type=\'%s\']/contact:birthDate', $date);
    }
}
