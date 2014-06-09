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
                $this->xpath->registerNamespace($prefix, $spec['namespace']);
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
        var_dump(get_class($nodes));
        if ($nodes instanceof DOMNodeList && $nodes->length > 0) {
            return $nodes;
        }
        return false;
    }

    public function __toString()
    {
        return $this->saveXML();
    }
}
