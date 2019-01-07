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
 * @see http://tools.ietf.org/html/rfc5731#section-3.1.1
 */
class Domain extends CheckCommand
{
    public function addDomain($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }
        $this->set('domain:name[]', $domain);
    }
}
