<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Info;

use AfriCC\EPP\Frame\Command\Info as InfoCommand;

/**
 * @see http://tools.ietf.org/html/rfc5733#section-3.1.2
 */
class Contact extends InfoCommand
{
    public function setId($id)
    {
        $this->set('contact:id', $id);
    }

    /**
     * Set contact authinfo
     *
     * @param string $pw authinfo
     */
    public function setAuthInfo($pw)
    {
        $this->set('contact:authInfo/contact:pw', $pw);
    }
}
