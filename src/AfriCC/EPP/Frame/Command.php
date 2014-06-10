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

use AfriCC\EPP\TransactionAwareInterface;
use AfriCC\EPP\AbstractFrame;

class Command extends AbstractFrame implements TransactionAwareInterface
{
    protected $format = 'command';
    protected $client_transaction_id;

    public function setClientTransactionId($cltrid) {
        $this->client_transaction_id->nodeValue = $cltrid;
    }

    public function getClientTransactionId() {
        return $this->client_transaction_id->nodeValue;
    }
}
