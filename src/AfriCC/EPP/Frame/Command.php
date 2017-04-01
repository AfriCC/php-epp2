<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame;

use AfriCC\EPP\AbstractFrame;
use AfriCC\EPP\TransactionAwareInterface;

abstract class Command extends AbstractFrame implements TransactionAwareInterface
{
    protected $clTRID;

    public function setClientTransactionId($clTRID)
    {
        $this->clTRID = substr($clTRID, 0, 64);
        $this->set('//epp:epp/epp:command/epp:clTRID', $this->clTRID);
    }

    public function getClientTransactionId()
    {
        return $this->clTRID;
    }
}
