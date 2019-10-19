<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command as CommandFrame;

/**
 * @see http://tools.ietf.org/html/rfc5730#section-2.9.2.3
 */
class Poll extends CommandFrame
{
    public function request()
    {
        $node = $this->set();
        $node->setAttribute('op', 'req');
    }

    public function ack($msgID)
    {
        $node = $this->set();
        $node->setAttribute('op', 'ack');
        $node->setAttribute('msgID', $msgID);
    }
}
