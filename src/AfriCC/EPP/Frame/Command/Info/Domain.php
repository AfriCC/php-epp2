<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Info;

use AfriCC\EPP\Frame\Command\Info as InfoCommand;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5731#section-3.1.2
 */
class Domain extends InfoCommand
{
    public function setDomain($domain, $return = 'all')
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }

        if (!in_array($return, ['all', 'del', 'sub', 'none'])) {
            throw new Exception(sprintf('%s is not a known return value', $return));
        }

        $this->set(sprintf('domain:name[@hosts=\'%s\']', $return), $domain);
    }

    public function setAuthInfo($pw, $roid = null)
    {
        $node = $this->set('domain:authInfo/domain:pw', $pw);

        if ($roid !== null) {
            $node->setAttribute('roid', $roid);
        }
    }
}
