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
    protected $format;
    protected $command;
    protected $mapping;
    protected $extension;

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
            foreach (ObjectSpec::$specs as $prefix => $spec) {
                $this->xpath->registerNamespace($prefix, $spec['xmlns']);
            }

            $this->registerNodeClass('\DOMElement', '\AfriCC\EPP\DOM\DOMElement');
        }

        $this->getStructure();
    }

    public function set($path = null, $value = null)
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

            $attr_name = $attr_value = null;

            // if no namespace given, use root-namespace
            if (strpos($path_parts[$i], ':') === false) {
                $node_ns = 'epp';
                $node_name = $path_parts[$i];
                $path_parts[$i] = $node_ns . ':' . $node_name;
            } else {
                list($node_ns, $node_name) = explode(':', $path_parts[$i], 2);
            }

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
            // direct node-array access
            if (preg_match('/^(.*)\[(\d+)\]$/', $node_name, $matches)) {
                $node_name = $matches[1];
            }
            // check if attribute needs to be set
            elseif (preg_match('/^(.*)\[@([a-z0-9]+)=\'([a-z0-9]+)\'\]$/i', $node_name, $matches)) {
                $node_name  = $matches[1];
                $attr_name  = $matches[2];
                $attr_value = $matches[3];
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

            // set attribute
            if ($attr_name !== null && $attr_value !== null) {
                $this->nodes[$node_path]->setAttribute($attr_name, $attr_value);
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
        if (isset($path{1}) && $path{0} === '/' && $path{1} === '/') {
            return substr($path, 2);
        }

        if ($path === null) {
            $path_parts = array();
        } else {
            $path_parts = explode('/', $path);
        }

        if (!empty($this->mapping) && !empty($this->command)) {
            array_unshift($path_parts, $this->mapping . ':' . $this->command);
        }

        if (!empty($this->command)) {
            array_unshift($path_parts, 'epp:' . $this->command);
        }

        if (!empty($this->format)) {
            array_unshift($path_parts, 'epp:' . $this->format);
        }

        array_unshift($path_parts, 'epp:epp');
        return implode('/', $path_parts);
    }

    private function getStructure()
    {
        // get class structure
        $classes = [get_class($this)];
        $classes = array_merge($classes, class_parents($this));

        foreach ($classes as $class) {
            $bare_class = $this->className($class);

            // stop when we reach self
            if ($bare_class === $this->className(__CLASS__)) {
                break;
            }

            // try to figure out the structure
            $parent_class = $this->className(get_parent_class($class));
            if ($parent_class === false) {
                continue;
            } elseif (empty($this->mapping) && in_array(strtolower($parent_class), ObjectSpec::$mappings)) {
                $this->mapping = strtolower($bare_class);
            } elseif (empty($this->command) && $parent_class === 'Command') {
                $this->command = strtolower($bare_class);
            } elseif ($parent_class === 'AbstractFrame') {
                $this->format  = strtolower($bare_class);
            }
        }

        if ($this instanceof ExtensionInterface) {
            $this->extension = strtolower($this->className(get_class($this)));
            // add to object spec
            ObjectSpec::$specs[$this->extension]['xmlns'] = $this->getExtensionNamespace();
        }
    }

    private function className($class)
    {
        if (!is_string($class)) {
            return $class;
        }
        if (($pos = strrpos($class, '\\')) === false) {
            return $class;
        }
        return substr($class, $pos + 1);
    }
}
