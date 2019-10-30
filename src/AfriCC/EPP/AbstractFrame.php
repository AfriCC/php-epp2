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
    /**
     * @var \DOMElement[]
     */
    protected $nodes;
    protected $format;
    protected $command;
    protected $mapping;

    /**
     * Extension name
     *
     * Redefine in case it's different than class name
     *
     * @var string
     */
    protected $extension;

    /**
     * Extension namespace
     *
     * Make sure to define it in class implementing ExtensionInterface
     *
     * @var string
     */
    protected $extension_xmlns;
    /**
     * @var bool whether to ignore command part when building realxpath
     */
    protected $ignore_command = false;

    /**
     * @var ObjectSpec custom objectspec used to create XML
     */
    protected $objectSpec;

    /**
     * Construct (with import if specified) frame
     *
     * Pass a DOMDocument instance to have it imported as a frame.
     * Pass an ObjectSpec instance to have it set as used ObjectSpec
     * More arguments will be ignored and only the last one will be used.
     */
    public function __construct()
    {
        parent::__construct('1.0', 'UTF-8');
        $this->xmlStandalone = false;
        $this->formatOutput = true;

        $import = null;

        $args = \func_get_args();
        foreach ($args as $arg) {
            if ($arg instanceof DOMDocument) {
                $import = $arg;
            }
            if ($arg instanceof ObjectSpec) {
                $this->objectSpec = $arg;
            }
        }

        if (\is_null($this->objectSpec)) {
            $this->objectSpec = new ObjectSpec();
        }

        $this->import($import);

        $this->registerXpath();

        $this->registerNodeClass('\DOMElement', '\AfriCC\EPP\DOM\DOMElement');

        $this->getStructure();
    }

    /**
     * Import frame data
     *
     * @param \DOMDocument $import
     */
    private function import(DOMDocument $import = null)
    {
        if (is_null($import)) {
            return;
        }
        $node = $this->importNode($import->documentElement, true);
        $this->appendChild($node);
    }

    private function registerXpath()
    {
        // register namespaces
        $this->xpath = new DOMXPath($this);
        foreach ($this->objectSpec->specs as $prefix => $spec) {
            $this->xpath->registerNamespace($prefix, $spec['xmlns']);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \AfriCC\EPP\FrameInterface::set()
     */
    public function set($path = null, $value = null)
    {
        $path = $this->realxpath($path);

        if (!isset($this->nodes[$path])) {
            $path = $this->createNodes($path);
        }

        if ($value !== null) {
            $this->nodes[$path]->nodeValue = htmlspecialchars($value, ENT_XML1, 'UTF-8');
        }

        return $this->nodes[$path];
    }

    /**
     * {@inheritdoc}
     *
     * @see \AfriCC\EPP\FrameInterface::get()
     */
    public function get($query)
    {
        $nodes = $this->xpath->query($query);
        if ($nodes === null || $nodes->length === 0) {
            return false;
        }

        // try to figure out what type is being requested
        $last_bit = substr(strrchr($query, '/'), 1);

        // @see http://stackoverflow.com/a/24730245/567193
        if ($nodes->length === 1 && (
                ($last_bit[0] === '@' && $nodes->item(0)->nodeType === XML_ATTRIBUTE_NODE) ||
                (stripos($last_bit, 'text()') === 0 && $nodes->item(0)->nodeType === XML_TEXT_NODE)
            )) {
            return $nodes->item(0)->nodeValue;
        } else {
            return $nodes;
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \AfriCC\EPP\FrameInterface::__toString()
     */
    public function __toString()
    {
        return $this->saveXML();
    }

    /**
     * Create nodes specified by path
     *
     * @param string $path
     *
     * @throws Exception
     *
     * @return null|string
     */
    protected function createNodes($path)
    {
        $path_parts = explode('/', $path);
        $node_path = null;

        for ($i = 0, $limit = count($path_parts); $i < $limit; ++$i) {
            $attr_name = $attr_value = $matches = null;

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

            if (preg_match('/^(.*)\[(\d+)\]$/', $node_name, $matches)) {
                // direct node-array access
                $node_name = $matches[1];
            } elseif (preg_match('/^(.*)\[@([a-z0-9]+)=\'([a-z0-9_]+)\'\]$/i', $node_name, $matches)) {
                // check if attribute needs to be set
                $node_name = $matches[1];
                $attr_name = $matches[2];
                $attr_value = $matches[3];
            }

            $node_path = implode('/', array_slice($path_parts, 0, $i + 1));

            if (isset($this->nodes[$node_path])) {
                continue;
            }

            // resolve node namespace
            $node_xmlns = $this->objectSpec->xmlns($node_ns);
            if ($node_xmlns === false) {
                throw new Exception(sprintf('unknown namespace: %s', $node_ns));
            }

            // create node (but don't explicitly define root-node)
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

    /**
     * Get Real XPath for provided path
     *
     * @param string $path
     *
     * @return string
     */
    protected function realxpath($path)
    {
        if ($path === null) {
            $path_parts = [];
        } elseif (isset($path[1]) && $path[0] === '/' && $path[1] === '/') {
            // absolute path
            return substr($path, 2);
        } else {
            $path_parts = explode('/', $path);
        }

        if (!empty($this->mapping) && !empty($this->command)) {
            array_unshift($path_parts, $this->mapping . ':' . $this->command);
        }

        if (!empty($this->command) && !$this->ignore_command) {
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
            } elseif (empty($this->mapping) && in_array(strtolower($parent_class), $this->objectSpec->mappings)) {
                $this->mapping = strtolower($bare_class);
            } elseif (empty($this->command) && $parent_class === 'Command') {
                $this->command = strtolower($bare_class);
            } elseif ($parent_class === 'AbstractFrame') {
                $this->format = strtolower($bare_class);
            }
        }

        if ($this instanceof ExtensionInterface) {
            // automatically guess extension according to class name if not defined in class
            if (!isset($this->extension)) {
                $this->extension = $this->getExtensionName();
            }

            // add to object spec
            $this->objectSpec->specs[$this->extension]['xmlns'] = $this->getExtensionNamespace();
        }
    }

    /**
     * Get Class name from full class
     *
     * @param string $class
     *
     * @return string
     */
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

    public function getExtensionName()
    {
        return strtolower($this->className(get_class($this)));
    }

    public function getExtensionNamespace()
    {
        if (empty($this->extension_xmlns) && ($this instanceof ExtensionInterface)) {
            throw new Exception(sprintf('Extension %s has no defined namespace', get_class($this)));
        }

        return $this->extension_xmlns;
    }
}
