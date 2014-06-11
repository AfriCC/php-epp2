<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Check;

use AfriCC\EPP\Frame\Command\Check as CheckCommand;

/**
 * @link http://tools.ietf.org/html/rfc5733#section-3.1.1
 */
class Contact extends CheckCommand
{
    public function addId($id)
    {
        $this->set('contact:id[]', $id);
    }
}