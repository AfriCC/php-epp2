<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Riccardo Bessone <riccardo@bess.one>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\NicIT\Transfer;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Transfer\Domain as DomainTransfer;

class Domain extends DomainTransfer implements Extension
{
    protected $extension = 'extdom';
    protected $extension_xmlns = 'http://www.nic.it/ITNIC-EPP/extdom-2.0';

    public function setNewRegistrant($registrant)
    {
        $this->set('//epp:epp/epp:command/epp:extension/extdom:trade/extdom:transferTrade/extdom:newRegistrant', $registrant);
    }

    public function setNewAuthInfo($pw)
    {
        $this->set('//epp:epp/epp:command/epp:extension/extdom:trade/extdom:transferTrade/extdom:newAuthInfo/extdom:pw', $pw);
    }
}
