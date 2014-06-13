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

use AfriCC\EPP\Frame\Response as ResponseFrame;


class MessageQueue extends ResponseFrame
{
    public function queueId()
    {
        return $this->get('//epp:epp/epp:response/epp:msgQ/@id');
    }

    public function queueCount()
    {
        return $this->get('//epp:epp/epp:response/epp:msgQ/@count');
    }

    public function queueMessage()
    {
        return $this->get('//epp:epp/epp:response/epp:msgQ/epp:msg/text()');
    }

    public function queueDate($format = null)
    {
        if ($format) {
            return date($format, strtotime($this->get('//epp:epp/epp:response/epp:msgQ/epp:qDate/text()')));
        }
        return $this->get('//epp:epp/epp:response/epp:msgQ/epp:qDate/text()');
    }
}