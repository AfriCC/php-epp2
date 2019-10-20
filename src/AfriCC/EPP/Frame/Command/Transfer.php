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
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5730#section-2.9.3.4
 */
abstract class Transfer extends CommandFrame
{
    public function setOperation($op)
    {
        if (!in_array($op, ['request', 'cancel', 'approve', 'reject', 'query'])) {
            throw new Exception(sprintf('%s is a unknown operation', $op));
        }

        $node = $this->set('//epp:epp/epp:command/epp:transfer');
        $node->setAttribute('op', $op);
    }
}
