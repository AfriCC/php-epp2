<?php
/**
 * @link http://tools.ietf.org/html/rfc5730#section-2.9.1.1
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command\Session;

use AfriCC\EPP\Frame\Command as CommandFrame;

class Login extends CommandFrame
{
    protected $command_name = 'login';
    protected $clid_node;
    protected $pw_node;
    protected $version_node;
    protected $lang_node;
    protected $services_node;
    protected $options_node;

    public function __construct()
    {
        parent::__construct();
        $this->clid_node = $this->createElement('clID');
        $this->command->appendChild($this->clid_node);

        $this->pw_node = $this->createElement('pw');
        $this->command->appendChild($this->pw_node);

        $this->options_node = $this->createElement('options');
        $this->command->appendChild($this->options_node);

        $this->version_node = $this->createElement('version');
        $this->options_node->appendChild($this->version_node);

        $this->lang_node = $this->createElement('lang');
        $this->options_node->appendChild($this->lang_node);

        $this->services_node = $this->createElement('svcs');
        $this->command->appendChild($this->services_node);
    }

    public function clientId($new_value = null)
    {
        if ($new_value !== null) {
            $this->clid_node->nodeValue = $new_value;
        }
        return $this->clid_node->nodeValue;
    }

    public function password($new_value = null)
    {
        if ($new_value !== null) {
            $this->pw_node->nodeValue = $new_value;
        }
        return $this->pw_node->nodeValue;
    }

    public function version($new_value = null)
    {
        if ($new_value !== null) {
            $this->version_node->nodeValue = $new_value;
        }
        return $this->version_node->nodeValue;
    }

    public function lang($new_value = null)
    {
        if ($new_value !== null) {
            $this->lang_node->nodeValue = $new_value;
        }
        return $this->lang_node->nodeValue;
    }

    public function addService($urn)
    {
        $objUri = $this->createElement('objURI', $urn);
        $this->services_node->appendChild($objUri);
        unset($objUri);
    }
}
