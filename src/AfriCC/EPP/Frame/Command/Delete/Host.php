<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Delete;

use AfriCC\EPP\Frame\Command\Delete as DeleteCommand;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5732#section-3.2.2
 */
class Host extends DeleteCommand
{
    public function setHost($host)
    {
        if (!Validator::isHostname($host)) {
            throw new Exception(sprintf('%s is not a valid host name', $host));
        }

        $this->set('host:name', $host);
    }
}
