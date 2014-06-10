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
use AfriCC\EPP\Validator;
use AfriCC\EPP\Random;
use Exception;

/**
 * @link http://tools.ietf.org/html/rfc5733#section-3.2.1
 */
class Contact extends CreateCommand
{
    protected $mapping = 'contact';

    public function setId($id)
    {
        $this->set('contact:id', $id);
    }

    public function setName($name)
    {
        $this->set('contact:postalInfo[@type=\'loc\']/contact:name', $name);
        $this->set('contact:postalInfo[@type=\'int\']/contact:name', $this->asciiTranslit($name));
    }

    public function setOrganization($org)
    {
        $this->set('contact:postalInfo[@type=\'loc\']/contact:org', $org);
        $this->set('contact:postalInfo[@type=\'int\']/contact:org', $this->asciiTranslit($org));
    }

    public function addStreet($street)
    {
        $this->set('contact:postalInfo[@type=\'loc\']/contact:addr/contact:street[]', $street);
        $this->set('contact:postalInfo[@type=\'int\']/contact:addr/contact:street[]', $this->asciiTranslit($street));
    }

    public function setCity($city)
    {
        $this->set('contact:postalInfo[@type=\'loc\']/contact:addr/contact:city', $city);
        $this->set('contact:postalInfo[@type=\'int\']/contact:addr/contact:city', $this->asciiTranslit($city));
    }

    public function setProvince($sp)
    {
        $this->set('contact:postalInfo[@type=\'loc\']/contact:addr/contact:sp', $sp);
        $this->set('contact:postalInfo[@type=\'int\']/contact:addr/contact:sp', $this->asciiTranslit($sp));
    }

    public function setPostalCode($pc)
    {
        $this->set('contact:postalInfo[@type=\'loc\']/contact:addr/contact:pc', $pc);
        $this->set('contact:postalInfo[@type=\'int\']/contact:addr/contact:pc', $this->asciiTranslit($pc));
    }

    public function setCountryCode($cc)
    {
        if (!Validator::isCountryCode($cc)) {
            throw new Exception(sprintf('the country-code: \'%s\' is unknown', $cc));
        }
        $this->set('contact:postalInfo[@type=\'loc\']/contact:addr/contact:cc', $cc);
        $this->set('contact:postalInfo[@type=\'int\']/contact:addr/contact:cc', $this->asciiTranslit($cc));
    }

    public function setVoice($voice)
    {
        $this->set('contact:voice', $voice);
    }

    public function setFax($fax)
    {
        $this->set('contact:fax', $fax);
    }

    public function setEmail($email)
    {
        if (!Validator::isEmail($email)) {
            throw new Exception(sprintf('%s is not a valid email', $email));
        }

        $this->set('contact:email', $email);
    }

    public function setAuthInfo($pw = null)
    {
        if ($pw === null) {
            $pw = Random::auth(12);
        }
        $this->set('contact:authInfo/contact:pw', $pw);
        return $pw;
    }

    public function addDisclose($value)
    {
        $this->set('contact:disclose[@flag=\'0\']/contact:' . $value);
    }

    protected function asciiTranslit($string)
    {
        // the reason for using this rather "exotic" function in contrary to
        // iconv is, that iconv is very unstable. It relies on the correct
        // linked library, which means it works different on OSX than on Linux
        // also iconv + setlocale is not thread safe, so if you are using IIS
        // php-fpm, fastcgi or similar it can/will break
        return transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0100-\u7fff] remove', $string);
    }
}
