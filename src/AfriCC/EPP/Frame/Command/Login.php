<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

class Login extends Command
{
    public function __construct()
    {
        parent::__construct('login');

        $this->clID = $this->createElement('clID');
        $this->command->appendChild($this->clID);

        $this->pw = $this->createElement('pw');
        $this->command->appendChild($this->pw);

        $this->options = $this->createElement('options');
        $this->command->appendChild($this->options);

        $this->eppVersion = $this->createElement('version');
        $this->options->appendChild($this->eppVersion);

        $this->eppLang = $this->createElement('lang');
        $this->options->appendChild($this->eppLang);

        $this->svcs = $this->createElement('svcs');
        $this->command->appendChild($this->svcs);

    }
}
