<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP;

use Exception;

trait ContactTrait
{
    /**
     * this was once needed as the conversion done by COZA was faulty
     * the bug has since been fixed but this remains to allow testing
     * set true to force ascii usage on type=loc (which should allow UTF8)
     *
     * @var bool
     */
    protected $force_ascii = false;

    /**
     * set true to skip the generation of type=int (like .MX)
     *
     * @var bool
     */
    protected $skip_int = false;

    abstract public function set($path = null, $value = null);

    public function forceAscii()
    {
        $this->force_ascii = true;
    }

    public function skipInt()
    {
        $this->skip_int = true;
    }

    public function appendId($path, $id)
    {
        $this->set($path, $id);
    }

    public function appendName($path, $name)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($name));
        } else {
            $this->set(sprintf($path, 'loc'), $name);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($name));
        }
    }

    public function appendOrganization($path, $org)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($org));
        } else {
            $this->set(sprintf($path, 'loc'), $org);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($org));
        }
    }

    public function appendStreet($path, $street)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($street));
        } else {
            $this->set(sprintf($path, 'loc'), $street);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($street));
        }
    }

    public function appendCity($path, $city)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($city));
        } else {
            $this->set(sprintf($path, 'loc'), $city);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($city));
        }
    }

    public function appendProvince($path, $sp)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($sp));
        } else {
            $this->set(sprintf($path, 'loc'), $sp);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($sp));
        }
    }

    public function appendPostalCode($path, $pc)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($pc));
        } else {
            $this->set(sprintf($path, 'loc'), $pc);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($pc));
        }
    }

    public function appendCountryCode($path, $cc)
    {
        if (!Validator::isCountryCode($cc)) {
            throw new Exception(sprintf('the country-code: \'%s\' is unknown', $cc));
        }

        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($cc));
        } else {
            $this->set(sprintf($path, 'loc'), $cc);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($cc));
        }
    }

    public function appendVoice($path, $voice)
    {
        $this->set($path, $voice);
    }

    public function appendFax($path, $fax)
    {
        $this->set($path, $fax);
    }

    public function appendEmail($path, $email)
    {
        if (!Validator::isEmail($email)) {
            throw new Exception(sprintf('%s is not a valid email', $email));
        }

        $this->set($path, $email);
    }

    public function appendAuthInfo($path, $pw = null)
    {
        if ($pw === null) {
            $pw = Random::auth(12);
        }
        $this->set($path, $pw);
        return $pw;
    }

    public function appendDisclose($path)
    {
        $this->set($path);
    }
}