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
use DOMXPath;
use Exception;

/**
 * This is a Frame implementation using DOMDocument that other Frames can
 * inherit from.
 */
abstract class AbstractFrame extends DOMDocument implements FrameInterface
{
    protected $xpath;
    protected $nodes;

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
            $this->xpath->registerNamespace('epp', ObjectSpec::xmlns('epp'));
            foreach (ObjectSpec::all() as $prefix => $spec) {
                $this->xpath->registerNamespace($prefix, $spec['xmlns']);
            }
        }
    }

    public function set($path, $value = null)
    {
        $path = $this->realxpath($path);

        if (!isset($this->nodes[$path])) {
            $path = $this->createNodes($path);
        }

        if ($value !== null) {
            $this->nodes[$path]->nodeValue = $value;
        }

        return $this->nodes[$path];
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

    protected function createNodes($path)
    {
        $path_parts = explode('/', $path);

        for ($i = 0, $limit = count($path_parts); $i < $limit; ++$i) {

            list($node_ns, $node_name) = explode(':', $path_parts[$i], 2);

            // check for node-array
            if (substr($node_name, -2) === '[]') {
                $node_name = substr($node_name, 0, -2);
                // get next key
                $next_key = -1;
                foreach (array_keys($this->nodes) as $each) {
                    if (preg_match('/' . preg_quote($node_ns . ':' . $node_name, '/') . '\[(\d+)\]$/', $each, $matches)) {
                        if ($matches[1] > $next_key) {
                            $next_key = (int) $matches[1];
                        }
                    }
                }
                ++$next_key;
                $path_parts[$i] = sprintf('%s:%s[%d]', $node_ns, $node_name, $next_key);
            }

            $node_path = implode('/', array_slice($path_parts, 0, $i + 1));

            if (isset($this->nodes[$node_path])) {
                continue;
            }

            // resolve node namespace
            $node_xmlns = ObjectSpec::xmlns($node_ns);
            if ($node_xmlns === false) {
                throw new Exception(sprintf('unknown namespace: %s', $node_ns));
            }

            // create node (but don't explicitely define root-node)
            if ($node_ns === 'epp') {
                $this->nodes[$node_path] = $this->createElementNS($node_xmlns, $node_name);
            } else {
                $this->nodes[$node_path] = $this->createElementNS($node_xmlns, $node_ns . ':' . $node_name);
            }

            // now append node to parent
            if ($i === 0) {
                $parent = $this;
            } else {
                $parent = $this->nodes[implode('/', array_slice($path_parts, 0, $i))];
            }
            $parent->appendChild($this->nodes[$node_path]);
        }

        return $node_path;
    }

    protected function realxpath($path)
    {
        // absolute path
        if ($path{0} === '/' && $path{1} === '/') {
            return substr($path, 2);
        }

        $path_parts = explode('/', $path);
        if (!empty($this->mapping_name) && !empty($this->command_name)) {
            array_unshift($path_parts, $this->mapping_name . ':' . $this->command_name);
        }

        if (!empty($this->format) && !empty($this->command_name)) {
            array_unshift($path_parts, 'epp:' . $this->command_name);
            array_unshift($path_parts, 'epp:' . $this->format);
        }

        array_unshift($path_parts, 'epp:epp');

        return implode('/', $path_parts);
    }
}
