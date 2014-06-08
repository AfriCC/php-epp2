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

    protected $knownFormats = array(
    	'hello' => true,
        'greeting' => true,
        'command' => true,
        'response' => true,
    );

    public function __construct($type)
    {
        parent::__construct('1.0', 'UTF-8');
        $this->xmlStandalone = false;
        $this->formatOutput = true;

        $this->appendChild($this->createElementNS(self::EPP_NS, 'epp'));

        $type = strtolower($type);
        if (!isset($this->knownFormats[$type])) {
            throw new Exception(sprintf('unknown format: %s', $type));
        }

        $this->epp = $this->firstChild;
        $this->body = $this->createElement($type);
        $this->epp->appendChild($this->body);
    }

    public function __toString()
    {
        return $this->saveXML();
    }
}
