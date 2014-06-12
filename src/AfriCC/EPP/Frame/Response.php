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
        if ($nodes === null || !($nodes instanceof DOMNodeList) || $nodes->length === 0 || !$nodes->item(0)->hasChildNodes()) {
            return;
        }

        $data = $this->nodeToArray($nodes->item(0));

        return $data;
    }

    private function nodeToArray(DOMNode $node)
    {
        $tmp = [];
        foreach ($node->childNodes as $each) {
            if ($each->nodeType !== XML_ELEMENT_NODE) {
                continue;
            }

            if ($each->hasChildNodes()) {
                if (isset($tmp[$each->localName])) {
                    if (!isset($tmp[$each->localName][0])) {
                        $tmp[$each->localName] = [$tmp[$each->localName]];
                    }
                    $tmp[$each->localName][] = $this->nodeToArray($each);
                } else {
                    $tmp[$each->localName] = $this->nodeToArray($each);
                }
            } else {
                $tmp[$each->localName] = $each->textContent;
                if ($each->hasAttributes()) {
                    foreach ($each->attributes as $attr) {
                        $tmp['@' . $each->localName][$attr->nodeName] = $attr->nodeValue;
                    }
                }
            }
        }

        return $tmp;
    }
}
