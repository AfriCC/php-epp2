<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Response;

use DOMElement;
use DOMNode;

class Result
{
    protected $code;

    protected $msg;

    protected $msgLang = 'en';

    protected $values = [];

    protected $extValues = [];

    public function __construct(DOMElement $node)
    {
        if ($node->hasAttribute('code')) {
            $this->code = (int) $node->getAttribute('code');
        }

        $this->parseResultNode($node);
    }

    public function success()
    {
        if ($this->code() >= 1000 && $this->code() < 2000) {
            return true;
        }

        return false;
    }

    public function code()
    {
        return $this->code;
    }

    public function message()
    {
        return $this->msg;
    }

    public function messageLanguage()
    {
        return $this->msgLang;
    }

    public function values()
    {
        return $this->values;
    }

    public function extValues()
    {
        return $this->extValues;
    }

    protected function parseResultNode($node)
    {
        foreach ($node->childNodes as $each) {
            if ($each->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            switch($each->localName) {
                case 'msg':
                    $this->msg = $each->nodeValue;
                    if ($each->hasAttribute('lang')) {
                        $this->msgLang = $each->getAttribute('lang');
                    }
                    break;

                case 'value':
                    $this->values = $this->nodeToArray($each);
                    break;

                case 'extValue':
                    break;

                default:
                    break;
            }
        }
    }

    private function nodeToArray(DOMNode $node)
    {
        $tmp = [];
        foreach ($node->childNodes as $each) {
            if ($each->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            // if node only has a type attribute lets distinguish them directly
            // and then ignore the attribtue
            if ($each->hasAttribute('type')) {
                $key = $each->localName . '@' . $each->getAttribute('type');
                $ignore_attributes = true;
            } else {
                $key = $each->localName;
                $ignore_attributes = false;
            }

            // in case of special keys, always create array
            if (isset($this->n2a_force_array[$key])) {
                $current = &$tmp[$key][];
                end($tmp[$key]);
                $insert_key = key($tmp[$key]);
            }
            // if key already exists, dynamically create an array
            elseif (isset($tmp[$key])) {
                if (!is_array($tmp[$key]) || !isset($tmp[$key][0])) {
                    $tmp[$key] = [$tmp[$key]];
                }
                $current = &$tmp[$key][];
                end($tmp[$key]);
                $insert_key = key($tmp[$key]);
            }
            // key was not yet set, so lets start off with a string
            else {
                $current = &$tmp[$key];
                $insert_key = null;
            }

            if ($each->hasChildNodes()) {
                $current = $this->nodeToArray($each);
            } else {
                $current = $each->nodeValue;

                if (!$ignore_attributes && !isset($this->n2a_ignore_attr[$each->localName]) && $each->hasAttributes()) {
                    foreach ($each->attributes as $attr) {

                        // single attribute with empty node, use the attr-value directly
                        if ($each->localName === 'status' || ($each->attributes->length === 1 && $each->nodeValue === '')) {
                            $current = $attr->nodeValue;
                            break;
                        }

                        if ($insert_key) {
                            if (isset($tmp['@' . $key][$attr->nodeName]) && !is_array($tmp['@' . $key][$attr->nodeName])) {
                                $tmp['@' . $key][$attr->nodeName] = [$tmp['@' . $key][$attr->nodeName]];
                            }
                            $tmp['@' . $key][$attr->nodeName][$insert_key] = $attr->nodeValue;
                        } else {
                            $tmp['@' . $key][$attr->nodeName] = $attr->nodeValue;
                        }
                    }
                }
            }
        }

        return $tmp;
    }
}
