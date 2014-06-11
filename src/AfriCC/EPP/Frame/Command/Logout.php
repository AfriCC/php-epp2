<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command as CommandFrame;

/**
 * @link http://tools.ietf.org/html/rfc5730#section-2.9.1.2
 */
class Logout extends CommandFrame
{
    public function __construct()
    {
        parent::__construct();
        $this->set();
    }
}
