<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Transfer;

use AfriCC\EPP\Frame\Command\Transfer as TransferCommand;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @link http://tools.ietf.org/html/rfc5731#section-3.2.4
 */
class Domain extends TransferCommand
{
    public function setDomain($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name'));
        }

        $this->set('domain:name', $domain);
    }

    public function setPeriod($period)
    {
        if (preg_match('/^(\d+)([a-z])$/i', $period, $matches)) {
            $this->set(sprintf('domain:period[@unit=\'%s\']', $matches[2]), $matches[1]);
        } else {
            throw new Exception(sprintf('%s is not a valid period', $period));
        }
    }

    public function setAuthInfo($pw, $roid = null)
    {
        $node = $this->set('domain:authInfo/domain:pw', $pw);

        if ($roid !== null) {
            $node->setAttribute('roid', $roid);
        }
    }
}
