<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Check;

use AfriCC\EPP\Frame\Command\Check as CheckCommand;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5732#section-3.1.1
 */
class Host extends CheckCommand
{
    public function addHost($host)
    {
        if (!Validator::isHostname($host)) {
            throw new Exception(sprintf('%s is not a valid host', $host));
        }
        $this->set('host:name[]', $host);
    }
}
