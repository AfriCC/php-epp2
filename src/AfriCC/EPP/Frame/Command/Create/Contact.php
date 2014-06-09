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

/**
 * @link http://tools.ietf.org/html/rfc5733#section-3.2.1
 */
class Contact extends CreateCommand
{
    protected $mapping_name = 'contact';
    protected $id_node;
    protected $postalinfo_node = array('int' => null, 'loc' => null);
    protected $postalinfo_nodes = array();
    protected $addr_nodes = array();

    public function setId($id)
    {
        if ($this->id_node instanceof DOMNode) {
            $this->id_node->nodeValue = $id;
        } else {
            $this->id_node = $this->addObjectProperty('id', $id);
        }
    }

    public function setName($name)
    {
        $this->createPostalInfoNode('name', $name);
    }

    public function setOrganization($organization)
    {
        $this->createPostalInfoNode('org', $organization);
    }

    public function addStreet($street)
    {
        $this->addPostalInfoAddr('street', $street);
    }

    public function setCity($city)
    {
        $this->setPostalInfoAddr('city', $city);
    }

    public function setProvince($province)
    {

    }

    public function setPostalCode($postalcode)
    {

    }

    public function setCountryCode($country)
    {

    }

    public function setVoice()
    {

    }

    public function setFax()
    {

    }

    public function setEmail()
    {

    }

    public function setAuthInfo()
    {

    }

    public function addDisclose()
    {

    }

    protected function createPostalInfoNodes()
    {
        if ($this->postalinfo_node['int'] === null) {
            $this->postalinfo_node['int'] = $this->addObjectProperty('postalInfo');
            $this->postalinfo_node['int']->setAttribute('type', 'int');
        }

        if ($this->postalinfo_node['loc'] === null) {
            $this->postalinfo_node['loc'] = $this->addObjectProperty('postalInfo');
            $this->postalinfo_node['loc']->setAttribute('type', 'loc');
        }
    }

    protected function createPostalInfoNode($node_name, $node_value = null)
    {
        $this->createPostalInfoNodes();

        if (!isset($this->postalinfo_nodes[$node_name]['loc'])) {
            $this->postalinfo_nodes[$node_name]['loc'] = $this->addObjectProperty($node_name, $node_value);
            $this->postalinfo_nodes[$node_name]['int'] = clone $this->postalinfo_nodes[$node_name]['loc'];

            if ($node_value !== null) {
                $this->postalinfo_nodes[$node_name]['int']->nodeValue = $this->asciiTranslit($this->postalinfo_nodes[$node_name]['int']->nodeValue);
            }

            $this->postalinfo_node['loc']->appendChild($this->postalinfo_nodes[$node_name]['loc']);
            $this->postalinfo_node['int']->appendChild($this->postalinfo_nodes[$node_name]['int']);
        } elseif (!$this->postalinfo_nodes[$node_name]['loc']->hasChildNodes()) {
            $this->postalinfo_nodes[$node_name]['loc']->nodeValue = $node_value;
            $this->postalinfo_nodes[$node_name]['int']->nodeValue = $this->asciiTranslit($node_value);
        }
    }

    protected function createPostalInfoAddr()
    {
        $this->createPostalInfoNode('addr');
    }

    protected function addPostalInfoAddr($node_name, $node_value)
    {
        $this->createPostalInfoAddr();

        $this->addObjectProperty($node_name, $node_value, $this->postalinfo_nodes['addr']['loc']);
        $this->addObjectProperty($node_name, $this->asciiTranslit($node_value), $this->postalinfo_nodes['addr']['int']);
    }

    protected function setPostalInfoAddr($node_name, $node_value)
    {
        $this->createPostalInfoAddr();

        $this->addr_nodes[$node_name]['loc'] = $this->addObjectProperty($node_name, $node_value, $this->postalinfo_nodes['addr']['loc']);
        $this->addr_nodes[$node_name]['int'] = $this->addObjectProperty($node_name, $node_value, $this->postalinfo_nodes['addr']['int']);
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
