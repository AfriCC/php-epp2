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

class Response extends AbstractFrame
{
    protected $format = 'response';

    public function code()
    {
        return (int) $this->get('//epp:epp/epp:response/epp:result/@code');
    }

    public function message()
    {
        return (string) $this->get('//epp:epp/epp:response/epp:result/epp:msg/text()');
    }
}
