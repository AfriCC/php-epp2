<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Update;

use AfriCC\EPP\Frame\Command\Update as UpdateCommand;

/**
 * @link http://tools.ietf.org/html/rfc5733#section-3.2.5
 */
class Contact extends UpdateCommand
{
    public function setId($id)
    {
        $this->set('contact:id', $id);
    }
}
