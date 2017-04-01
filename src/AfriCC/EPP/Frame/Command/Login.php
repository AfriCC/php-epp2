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
 * @see http://tools.ietf.org/html/rfc5730#section-2.9.1.1
 */
class Login extends CommandFrame
{
    public function setClientId($clID)
    {
        $this->set('clID', $clID);
    }

    public function setPassword($pw)
    {
        $this->set('pw', $pw);
    }

    public function setNewPassword($newPW)
    {
        $this->set('newPW', $newPW);
    }

    public function setVersion($version)
    {
        $this->set('options/version', $version);
    }

    public function setLanguage($lang)
    {
        $this->set('options/lang', $lang);
    }

    public function addService($urn)
    {
        $this->set('svcs/objURI[]', $urn);
    }

    public function addServiceExtension($uri)
    {
        $this->set('svcs/svcExtension/extURI[]', $uri);
    }
}
