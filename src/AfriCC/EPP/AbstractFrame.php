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

use DOMDocument;
use DOMNodeList;
use DOMXPath;
use Exception;

/**
 * This is a Frame implementation using DOMDocument that other Frames can
 * inherit from.
 */
abstract class AbstractFrame extends DOMDocument implements FrameInterface
{
    protected $format_name;
    protected $xpath;

    public function __construct($import = null)
    {
        parent::__construct('1.0', 'UTF-8');
        $this->xmlStandalone = false;
        $this->formatOutput = true;

        if ($import instanceof DOMDocument) {
            $node = $this->importNode($import->documentElement, true);
            $this->appendChild($node);

            // register namespaces
            $this->xpath = new DOMXPath($this);
            $this->xpath->registerNamespace('epp', ObjectSpec::ROOT_NS);
            foreach (ObjectSpec::all() as $prefix => $spec) {
                $this->xpath->registerNamespace($prefix, $spec['xmlns']);
            }

        } else {
            $this->appendChild($this->createElementNS(ObjectSpec::ROOT_NS, 'epp'));

            $this->epp = $this->firstChild;
            $this->body = $this->createElement($this->format_name);
            $this->epp->appendChild($this->body);
        }
    }

    public function get($query)
    {
        $nodes = $this->xpath->query($query);
        if ($nodes === null || $nodes->length === 0) {
            return false;
        }

        // try to figure out what type is being requested
        $last_bit = substr(strrchr($query, '/'), 1);

        if ($last_bit{0} === '@' && $nodes->length === 1 && $nodes->item(0)->nodeType === XML_ATTRIBUTE_NODE) {
            return $nodes->item(0)->value;
        } elseif (stripos($last_bit, 'text()') === 0 && $nodes->length === 1 && $nodes->item(0)->nodeType === XML_TEXT_NODE) {
            return $nodes->item(0)->nodeValue;
        } else {
            return $nodes;
        }
    }

    public function __toString()
    {
        return $this->saveXML();
    }
}
