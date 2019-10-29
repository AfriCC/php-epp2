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
use AfriCC\EPP\ObjectSpec;

/**
 * @see https://tools.ietf.org/html/rfc5730#section-2.3
 */
class Hello extends AbstractFrame
{
    public function __construct(ObjectSpec $objectSpec = null)
    {
        parent::__construct($objectSpec);
        $this->set('//epp:epp/epp:hello');
    }
}
