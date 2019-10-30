<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Riccardo Bessone <riccardo@bess.one>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\NicIT\Info;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Info\Domain as DomainInfo;
use Exception;

class Domain extends DomainInfo implements Extension
{
    protected $extension = 'extdom';
    protected $extension_xmlns = 'http://www.nic.it/ITNIC-EPP/extdom-2.0';

    public function setInfContacts($op = null)
    {
        if (!is_null($op)) {
            if (!in_array($op, ['all', 'registrant', 'admin', 'tech'])) {
                throw new Exception(sprintf('%s is not a known contact type value', $op));
            }

            $this->set(sprintf('//epp:epp/epp:command/epp:extension/extdom:infContacts[@op=\'%s\']', $op));
        }
    }
}
