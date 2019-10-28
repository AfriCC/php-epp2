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

use AfriCC\EPP\AddrTrait;
use AfriCC\EPP\Frame\Command\Update as UpdateCommand;
use AfriCC\EPP\Random;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5731#section-3.2.5
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

    public function addBillingContact($contact, $remove = false)
    {
        if ($remove) {
            $key = 'rem';
        } else {
            $key = 'add';
        }

        $this->set(sprintf('domain:%s/domain:contact[@type=\'billing\']', $key), $contact);
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

    /**
     * Add/remove SecDNS dsData - RFC 5910
     *
     * @param int $keyTag
     * @param int $alg
     * @param int $digestType
     * @param string $digest
     * @param bool $remove whether to remove or add (default add)
     */
    public function addSecDNSdsData($keyTag, $alg, $digestType, $digest, $remove = false)
    {
        $key = $remove ? 'rem' : 'add';
        $node = $this->set(sprintf('//epp:epp/epp:command/epp:extension/secDNS:update/secDNS:%s/secDNS:dsData[]', $key));
        $ns = $this->objectSpec->xmlns('secDNS');
        $keyTagNode = $this->createElementNS($ns, 'secDNS:keyTag', $keyTag);
        $algNode = $this->createElementNS($ns, 'secDNS:alg', $alg);
        $digestTypeNode = $this->createElementNS($ns, 'secDNS:digestType', $digestType);
        $digestNode = $this->createElementNS($ns, 'secDNS:digest', $digest);
        $node->appendChild($keyTagNode);
        $node->appendChild($algNode);
        $node->appendChild($digestTypeNode);
        $node->appendChild($digestNode);
    }

    /**
     * Add/remove SecDNS dsData - RFC 5910
     *
     * @param int $keyTag
     * @param int $alg
     * @param int $digestType
     * @param string $digest
     */
    public function removeSecDNSdsData($keyTag, $alg, $digestType, $digest)
    {
        $this->addSecDNSdsData($keyTag, $alg, $digestType, $digest, true);
    }

    /**
     * Remove all secDNS data - RFC 5910
     *
     * @param bool $all - whether to remove ALL (true) or do nothing (false)
     */
    public function removeSecDNSAll($all = true)
    {
        $this->set('//epp:epp/epp:command/epp:extension/secDNS:update/secDNS:rem/secDNS:all', $all ? 'true' : 'false');
    }

    public function removeAdminContact($contact)
    {
        $this->addAdminContact($contact, true);
    }

    public function removeTechContact($contact)
    {
        $this->addTechContact($contact, true);
    }

    public function removeBillingContact($contact)
    {
        $this->addBillingContact($contact, true);
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
