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
use AfriCC\EPP\Validator;
use AfriCC\EPP\Random;
use AfriCC\EPP\AddrTrait;
use Exception;

/**
 * @link http://tools.ietf.org/html/rfc5731#section-3.2.5
 */
class Domain extends UpdateCommand
{
    use AddrTrait;

    public function setDomain($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }
        $this->set('domain:name', $domain);
    }

    public function addAdminContact($contact, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            $key = 'add';
        }

        $this->set(sprintf('domain:%s/domain:contact[@type=\'admin\']', $key), $contact);
    }

    public function addTechContact($contact, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            $key = 'add';
        }

        $this->set(sprintf('domain:%s/domain:contact[@type=\'tech\']', $key), $contact);
    }

    public function addHostObj($host, $remove = false)
    {
        if (!Validator::isHostname($host)) {
            throw new Exception(sprintf('%s is not a valid host name', $host));
        }

        if ($remove) {
            $key = 'rem';
        } else {
            $key = 'add';
        }

        $this->set(sprintf('domain:%s/domain:ns/domain:hostObj[]', $key), $host);
    }

    public function addHostAttr($host, $ips = null, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            $key = 'add';
        }

        $this->appendHostAttr(sprintf('domain:%s/domain:ns/domain:hostAttr[%%d]', $key), $host, $ips);
    }

    public function addStatus($status, $text, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            $key = 'add';
        }

        $node = $this->set(sprintf('domain:%s/domain:status[@s=\'%s\']', $key, $status));
        if (!empty($text)) {
            $node->setAttribute('lang', 'en');
            $node->nodeValue = $text;
        }
    }

    public function removeAdminContact($contact)
    {
        $this->addAdminContact($contact, true);
    }

    public function removeTechContact($contact)
    {
        $this->addTechContact($contact, true);
    }

    public function removeHostObj($host)
    {
        $this->addHostObj($host, true);
    }

    public function removeHostAttr($host, $ips = null)
    {
        $this->addHostAttr($host, $ips, true);
    }

    public function removeStatus($status)
    {
        $this->addStatus($status, null, true);
    }

    public function changeRegistrant($registrant)
    {
        $this->set('domain:chg/domain:registrant', $registrant);
    }

    public function changeAuthInfo($pw = null)
    {
        if ($pw === null) {
            $pw = Random::auth(12);
        }

        $this->set('domain:chg/domain:authInfo/domain:pw', $pw);

        return $pw;
    }
}
