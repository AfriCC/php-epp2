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

            if ($each->localName === 'postalInfo' && $each->hasAttribute('type')) {
                $key = $each->localName . '@' . $each->getAttribute('type');
            } else {
                $key = $each->localName;
            }

            if (isset($tmp[$key])) {
                if (!is_array($tmp[$key]) || !isset($tmp[$key][0])) {
                    $tmp[$key] = [$tmp[$key]];
                }
                $current = &$tmp[$key][];
                $insert_key = key($tmp[$key]);
            } else {
                $current = &$tmp[$key];
                $insert_key = null;
            }

            if ($each->hasChildNodes()) {
                $current = $this->nodeToArray($each);
            } else {
                $current = $each->textContent;

                if ($each->hasAttributes()) {
                    foreach ($each->attributes as $attr) {
                        if ($insert_key) {
                            $tmp['@' . $key][$insert_key][$attr->nodeName] = $attr->nodeValue;
                        } elseif ($each->attributes->length === 1 && $each->textContent === '') {
                            $current = $attr->nodeValue;
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
