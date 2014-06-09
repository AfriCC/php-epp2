<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame;

use AfriCC\EPP\Frame;

final class Greeting extends Frame
{
    protected $format = 'greeting';

    function __construct()
    {
        parent::__construct();

        $this->svID = $this->createElement('svID');
        $this->body->appendChild($this->svID);

        $this->svDate = $this->createElement('svDate');
        $this->body->appendChild($this->svDate);

        $this->svcMenu = $this->createElement('svcMenu');
        $this->body->appendChild($this->svcMenu);

        $this->dcp = $this->createElement('dcp');
        $this->body->appendChild($this->dcp);

    }
}
