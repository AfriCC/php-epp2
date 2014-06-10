<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Renew;

use AfriCC\EPP\Frame\Command\Renew as RenewCommand;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @link http://tools.ietf.org/html/rfc5731#section-3.2.3
 */
class Domain extends RenewCommand
{
    protected $mapping = 'domain';

    public function setDomain($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }

        $this->set('domain:name', $domain);
    }

    public function setCurrentExpirationDate($curExpDate)
    {
        $this->set('domain:curExpDate', $curExpDate);
    }

    public function setPeriod($period)
    {
        if (preg_match('/^(\d+)([a-z])$/i', $period, $matches)) {
            $this->set(sprintf('domain:period[@unit=\'%s\']', $matches[2]), $matches[1]);
        } else {
            throw new Exception(sprintf('%s is not a valid period', $period));
        }
    }
}
