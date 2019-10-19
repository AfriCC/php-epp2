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
use AfriCC\EPP\DOM\DOMTools;
use AfriCC\EPP\Frame\Response\Result;
use DOMNodeList;

/**
 * @see http://tools.ietf.org/html/rfc5730#section-2.6
 */
class Response extends AbstractFrame
{
    /**
     * Get Results from response frame
     *
     * @return Result[]
     */
    public function results()
    {
        $results = [];
        $nodes = $this->get('//epp:epp/epp:response/epp:result');
        foreach ($nodes as $node) {
            $results[] = new Result($node);
        }

        return $results;
    }

    /**
     * Whether response is successful
     *
     * @todo On response with multiple codes this fails miserably
     *
     * @return bool true on succes, false otherwise.
     */
    public function success()
    {
        $code = $this->code();
        if ($code >= 1000 && $code < 2000) {
            return true;
        }

        return false;
    }

    /**
     * Get Response code
     *
     * @todo on response with multiple results this fails miserably
     *
     * @return int response code
     */
    public function code()
    {
        return (int) $this->get('//epp:epp/epp:response/epp:result/@code');
    }

    /**
     * Get Response message
     *
     * @todo check message against multiple responses
     *
     * @return string message
     */
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
            $data = [];
        } else {
            $data = DOMTools::nodeToArray($nodes->item(0));
        }

        // check for extension data
        $nodes = $this->get('//epp:epp/epp:response/epp:extension');
        if ($nodes !== false && $nodes instanceof DOMNodeList && $nodes->length > 0 && $nodes->item(0)->hasChildNodes()) {
            $data = array_merge_recursive($data, DOMTools::nodeToArray($nodes->item(0)));
        }

        return $data;
    }
}
