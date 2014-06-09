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
        $nodes = $this->get('//epp:epp/epp:response/epp:result/@code');
        var_dump((string) $nodes->item(0));
        exit;
        //return $this->getElementsByTagName('result')->item(0)->getAttribute('code');
    }

    public function message()
    {
        return $this->getElementsByTagName('msg')->item(0)->firstChild->textContent;
    }
}
