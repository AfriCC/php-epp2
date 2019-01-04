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
     * This was once needed as the conversion done by COZA was faulty
     * the bug has since been fixed but this remains to allow testing
     * set true to force ascii usage on type=loc (which should allow UTF8).
     *
     * @var bool
     */
    protected $force_ascii = false;

    /**
     * Set true to skip the generation of type=int.
     *
     * @var bool
     */
    protected $skip_int = false;

    /**
     * Set true to skip the generation of type=loc.
     *
     * @var bool
     */
    protected $skip_loc = false;

    /**
     * @param string $path
     * @param mixed $value
     *
     * @return \DOMElement
     */
    abstract public function set($path = null, $value = null);

    /**
     * Whether to force ASCI on loc contacts
     *
     * @param bool $value
     *
     * @see \AfriCC\EPP\ContactTrait::force_ascii
     */
    public function forceAscii($value = true)
    {
        $this->force_ascii = $value;
    }

    /**
     * Skip the generation of type=int.
     *
     * @param bool $value
     */
    public function skipInt($value = true)
    {
        $this->skip_int = $value;
    }

    /**
     * Skip the generation of type=loc.
     *
     * @param bool $value
     */
    public function skipLoc($value = true)
    {
        $this->skip_loc = $value;
    }

    public function appendId($path, $id)
    {
        $this->set($path, $id);
    }

    public function appendName($path, $name)
    {
        if (!$this->skip_loc) {
            $this->set(sprintf($path, 'loc'), $this->force_ascii ? Translit::transliterate($name) : $name);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($name));
        }
    }

    public function appendOrganization($path, $org)
    {
        if (!$this->skip_loc) {
            $this->set(sprintf($path, 'loc'), $this->force_ascii ? Translit::transliterate($org) : $org);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($org));
        }
    }

    public function appendStreet($path, $street)
    {
        if (!$this->skip_loc) {
            $this->set(sprintf($path, 'loc'), $this->force_ascii ? Translit::transliterate($street) : $street);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($street));
        }
    }

    public function appendCity($path, $city)
    {
        if (!$this->skip_loc) {
            $this->set(sprintf($path, 'loc'), $this->force_ascii ? Translit::transliterate($city) : $city);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($city));
        }
    }

    public function appendProvince($path, $sp)
    {
        if (!$this->skip_loc) {
            $this->set(sprintf($path, 'loc'), $this->force_ascii ? Translit::transliterate($sp) : $sp);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($sp));
        }
    }

    public function appendPostalCode($path, $pc)
    {
        if (!$this->skip_loc) {
            $this->set(sprintf($path, 'loc'), $this->force_ascii ? Translit::transliterate($pc) : $pc);
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

        if (!$this->skip_loc) {
            $this->set(sprintf($path, 'loc'), $this->force_ascii ? Translit::transliterate($cc) : $cc);
        }

        if (!$this->skip_int) {
            $this->set(sprintf($path, 'int'), Translit::transliterate($cc));
        }
    }

    public function appendVoice($path, $voice, $extension = null)
    {
        $node = $this->set($path, $voice);

        if (!is_null($extension)) {
            $node->setAttribute('x', $extension);
        }
    }

    public function appendFax($path, $fax, $extension = null)
    {
        $node = $this->set($path, $fax);

        if (!is_null($extension)) {
            $node->setAttribute('x', $extension);
        }
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
