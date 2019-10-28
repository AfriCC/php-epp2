<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP\Frame\Command\Create;

use AfriCC\EPP\AddrTrait;
use AfriCC\EPP\Frame\Command\Create as CreateCommand;
use AfriCC\EPP\PeriodTrait;
use AfriCC\EPP\Random;
use AfriCC\EPP\Validator;
use Exception;

/**
 * @see http://tools.ietf.org/html/rfc5731#section-3.2.1
 */
class Domain extends CreateCommand
{
    use PeriodTrait, AddrTrait;

    public function setDomain($domain)
    {
        if (!Validator::isHostname($domain)) {
            throw new Exception(sprintf('%s is not a valid domain name', $domain));
        }

        $this->set('domain:name', $domain);
    }

    public function setPeriod($period)
    {
        $this->appendPeriod('domain:period[@unit=\'%s\']', $period);
    }

    public function addHostObj($host)
    {
        if (!Validator::isHostname($host)) {
            throw new Exception(sprintf('%s is not a valid host name', $host));
        }

        $this->set('domain:ns/domain:hostObj[]', $host);
    }

    public function addHostAttr($host, $ips = null)
    {
        $this->appendHostAttr('domain:ns/domain:hostAttr[%d]', $host, $ips);
    }

    public function setRegistrant($registrant)
    {
        $this->set('domain:registrant', $registrant);
    }

    public function setAdminContact($admin_contact)
    {
        $this->set('domain:contact[@type=\'admin\']', $admin_contact);
    }

    public function setTechContact($tech_contact)
    {
        $this->set('domain:contact[@type=\'tech\']', $tech_contact);
    }

    public function setBillingContact($billing_contact)
    {
        $this->set('domain:contact[@type=\'billing\']', $billing_contact);
    }

    public function setAuthInfo($pw = null)
    {
        if ($pw === null) {
            $pw = Random::auth(12);
        }

        $this->set('domain:authInfo/domain:pw', $pw);

        return $pw;
    }

    /**
     * Add SecDNS dsData - RFC 5910
     *
     * @param int $keyTag
     * @param int $alg
     * @param int $digestType
     * @param string $digest
     */
    public function addSecDNSdsData($keyTag, $alg, $digestType, $digest)
    {
        $node = $this->set('//epp:epp/epp:command/epp:extension/secDNS:create/secDNS:dsData[]');
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
}
