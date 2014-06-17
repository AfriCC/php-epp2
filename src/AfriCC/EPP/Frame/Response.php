<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame;

use AfriCC\EPP\AbstractFrame;
use DOMNodeList;
use DOMNode;

/**
 * @link http://tools.ietf.org/html/rfc5730#section-2.6
 */
class Response extends AbstractFrame
{
    /**
     * nodeToArray force array values for the following tags. Usually the upper
     * level will expect them as an array to traverse. Otherwise, if only one
     * value exists it will be converted directly to a string
     * @var array
     */
    protected $n2a_force_array = [
        'hostAttr' => true,
        'hostObj'  => true,
        'street'   => true,
        'hostAddr' => true,
    ];

    /**
     * nodeToArray ignore conversion of following attributes. Usually because
     * the information is redundant or useless (like the definition of IP types
     * which should be done on the higher level)
     * @var array
     */
    protected $n2a_ignore_attr = [
        'hostAddr' => true,
    ];

    public function success()
    {
        $code = $this->code();
        if ($code >= 1000 && $code < 2000) {
            return true;
        }
        return false;
    }

    public function code()
    {
        return (int) $this->get('//epp:epp/epp:response/epp:result/@code');
    }

    public function message()
    {
        return (string) $this->get('//epp:epp/epp:response/epp:result/epp:msg/text()');
    }

    public function clientTransactionId()
    {
        $value = $this->get('//epp:epp/epp:response/epp:trID/epp:clTRID/text()');
        if ($value === false) {
            return;
        }
        return (string) $value;
    }

    public function serverTransactionId()
    {
        $value = $this->get('//epp:epp/epp:response/epp:trID/epp:svTRID/text()');
        if ($value === false) {
            return;
        }
        return (string) $value;
    }

    public function data()
    {
        $nodes = $this->get('//epp:epp/epp:response/epp:resData');
        if ($nodes === false || !($nodes instanceof DOMNodeList) || $nodes->length === 0 || !$nodes->item(0)->hasChildNodes()) {
            return;
        }

        $data = $this->nodeToArray($nodes->item(0));

        // check for extension data
        $nodes = $this->get('//epp:epp/epp:response/epp:extension');
        if ($nodes !== false && $nodes instanceof DOMNodeList && $nodes->length > 0 && $nodes->item(0)->hasChildNodes()) {
            $data = array_merge_recursive($data, $this->nodeToArray($nodes->item(0)));
        }

        return $data;
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
