<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP;

/**
 * Describes a transaction-aware instance, e.g. one that SHOULD handle clTRID
 */
interface TransactionAwareInterface
{
    public function setClientTransactionId($cltrid);

    public function getClientTransactionId();
}
