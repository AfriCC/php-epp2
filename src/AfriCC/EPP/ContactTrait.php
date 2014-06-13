<?php

namespace AfriCC\EPP;

use Exception;

trait ContactTrait
{
    protected $force_ascii = false;

    public function forceAscii()
    {
        $this->force_ascii = true;
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

        $this->set(sprintf($path, 'int'), Translit::transliterate($name));
    }

    public function appendOrganization($path, $org)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($org));
        } else {
            $this->set(sprintf($path, 'loc'), $org);
        }

        $this->set(sprintf($path, 'int'), Translit::transliterate($org));
    }

    public function appendStreet($path, $street)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($street));
        } else {
            $this->set(sprintf($path, 'loc'), $street);
        }

        $this->set(sprintf($path, 'int'), Translit::transliterate($street));
    }

    public function appendCity($path, $city)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($city));
        } else {
            $this->set(sprintf($path, 'loc'), $city);
        }

        $this->set(sprintf($path, 'int'), Translit::transliterate($city));
    }

    public function appendProvince($path, $sp)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($sp));
        } else {
            $this->set(sprintf($path, 'loc'), $sp);
        }

        $this->set(sprintf($path, 'int'), Translit::transliterate($sp));
    }

    public function appendPostalCode($path, $pc)
    {
        if ($this->force_ascii) {
            $this->set(sprintf($path, 'loc'), Translit::transliterate($pc));
        } else {
            $this->set(sprintf($path, 'loc'), $pc);
        }

        $this->set(sprintf($path, 'int'), Translit::transliterate($pc));
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

        $this->set(sprintf($path, 'int'), Translit::transliterate($cc));
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