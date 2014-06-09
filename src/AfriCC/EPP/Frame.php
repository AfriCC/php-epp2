<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP;

use DOMDocument;
use Exception;

abstract class Frame extends DOMDocument
{
    const EPP_NS        = 'urn:ietf:params:xml:ns:epp-1.0';
    const SCHEMA_URI    = 'http://www.w3.org/2001/XMLSchema-instance';

    protected $format_name;

    public function __construct()
    {
        parent::__construct('1.0', 'UTF-8');
        $this->xmlStandalone = false;
        $this->formatOutput = true;

        $this->appendChild($this->createElementNS(self::EPP_NS, 'epp'));

        $this->epp = $this->firstChild;
        $this->body = $this->createElement($this->format_name);
        $this->epp->appendChild($this->body);
    }

    public function __toString()
    {
        return $this->saveXML();
    }
}
