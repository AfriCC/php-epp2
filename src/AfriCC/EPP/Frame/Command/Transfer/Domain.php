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
use AfriCC\EPP\PeriodTrait;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5731#section-3.2.4
 */
class Domain extends TransferCommand
{
    use PeriodTrait;

    public function setDomain($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }

        $this->set('domain:name', $domain);
    }

    public function setPeriod($period)
    {
        $this->appendPeriod('domain:period[@unit=\'%s\']', $period);
    }

    public function setAuthInfo($pw, $roid = null)
    {
        $node = $this->set('domain:authInfo/domain:pw', $pw);

        if ($roid !== null) {
            $node->setAttribute('roid', $roid);
        }
    }
}
