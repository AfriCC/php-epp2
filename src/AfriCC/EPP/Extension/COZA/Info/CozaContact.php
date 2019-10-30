<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Extension\COZA\Info;

use AfriCC\EPP\ExtensionInterface as Extension;
use AfriCC\EPP\Frame\Command\Info\Contact as ContactInfo;

/**
 * @see https://www.registry.net.za/content.php?wiki=1&contentid=18&title=EPP%20Contact%20Extensions
 */
class CozaContact extends ContactInfo implements Extension
{
    protected $extension_xmlns = 'http://co.za/epp/extensions/cozacontact-1-0';

    public function requestBalance()
    {
        $this->set('//epp:epp/epp:command/epp:extension/cozacontact:info/cozacontact:balance', 'true');
    }

    public function requestDomainListing()
    {
        $this->set('//epp:epp/epp:command/epp:extension/cozacontact:info/cozacontact:domainListing', 'true');
    }
}
