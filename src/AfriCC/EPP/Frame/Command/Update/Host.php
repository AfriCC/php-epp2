<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Update;

use AfriCC\EPP\AddrTrait;
use AfriCC\EPP\Frame\Command\Update as UpdateCommand;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5732#section-3.2.5
 */
class Host extends UpdateCommand
{
    use AddrTrait;

    public function setHost($host)
    {
        if (!Validator::isHostname($host)) {
            throw new Exception(sprintf('%s is not a valid host name', $host));
        }

        $this->set('host:name', $host);
    }

    public function addAddr($ip)
    {
        $this->appendAddr('host:add/host:addr[]', $ip);
    }

    public function addStatus($status)
    {
        $this->set(sprintf('host:add/host:status[@s=\'%s\']', $status));
    }

    public function removeAddr($ip)
    {
        $this->appendAddr('host:rem/host:addr[]', $ip);
    }

    public function removeStatus($status)
    {
        $this->set(sprintf('host:rem/host:status[@s=\'%s\']', $status));
    }

    public function changeHost($host)
    {
        if (!Validator::isHostname($host)) {
            throw new Exception(sprintf('%s is not a valid host name', $host));
        }

        $this->set('host:chg/host:name', $host);
    }
}
