<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Delete;

use AfriCC\EPP\Frame\Command\Delete as DeleteCommand;

/**
 * @see http://tools.ietf.org/html/rfc5733#section-3.2.2
 */
class Contact extends DeleteCommand
{
    public function setId($id)
    {
        $this->set('contact:id', $id);
    }
}
