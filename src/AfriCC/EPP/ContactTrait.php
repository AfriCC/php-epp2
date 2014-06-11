<?php

namespace AfriCC\EPP;

use Exception;

trait ContactTrait
{
    public function appendId($path, $id)
    {
        $this->set($path, $id);
    }

    public function appendName($path, $name)
    {
        $this->set(sprintf($path, 'loc'), $name);
        $this->set(sprintf($path, 'int'), Translit::transliterate($name));
    }

    public function appendOrganization($path, $org)
    {
        $this->set(sprintf($path, 'loc'), $org);
        $this->set(sprintf($path, 'int'), Translit::transliterate($org));
    }

    public function appendStreet($path, $street)
    {
        $this->set(sprintf($path, 'loc'), $street);
        $this->set(sprintf($path, 'int'), Translit::transliterate($street));
    }

    public function appendCity($path, $city)
    {
        $this->set(sprintf($path, 'loc'), $city);
        $this->set(sprintf($path, 'int'), Translit::transliterate($city));
    }

    public function appendProvince($path, $sp)
    {
        $this->set(sprintf($path, 'loc'), $sp);
        $this->set(sprintf($path, 'int'), Translit::transliterate($sp));
    }

    public function appendPostalCode($path, $pc)
    {
        $this->set(sprintf($path, 'loc'), $pc);
        $this->set(sprintf($path, 'int'), Translit::transliterate($pc));
    }

    public function appendCountryCode($path, $cc)
    {
        if (!Validator::isCountryCode($cc)) {
            throw new Exception(sprintf('the country-code: \'%s\' is unknown', $cc));
        }
        $this->set(sprintf($path, 'loc'), $cc);
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