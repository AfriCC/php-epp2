<?php

namespace AfriCC\Tests\EPP\Frame\Command\Create;

use AfriCC\EPP\Frame\Command\Create\Domain;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainCreateTest extends TestCase
{
    public function testDomainCreateFrame()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->setPeriod('1y');
        $frame->addHostObj('ns3.' . TEST_DOMAIN);
        $frame->addHostAttr('ns2.' . TEST_DOMAIN);
        $frame->addHostAttr('ns1.' . TEST_DOMAIN, [
            '8.8.8.8',
            '2a00:1450:4009:809::100e',
        ]);
        $frame->setRegistrant('C001');
        $frame->setAdminContact('C002');
        $frame->setTechContact('C003');
        $frame->setBillingContact('C004');
        $auth = $frame->setAuthInfo();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <domain:create xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:period unit="y">1</domain:period>
                    <domain:ns>
                      <domain:hostObj>ns3.' . TEST_DOMAIN . '</domain:hostObj>
                      <domain:hostAttr>
                        <domain:hostName>ns2.' . TEST_DOMAIN . '</domain:hostName>
                      </domain:hostAttr>
                      <domain:hostAttr>
                        <domain:hostName>ns1.' . TEST_DOMAIN . '</domain:hostName>
                        <domain:hostAddr ip="v4">8.8.8.8</domain:hostAddr>
                        <domain:hostAddr ip="v6">2a00:1450:4009:809::100e</domain:hostAddr>
                      </domain:hostAttr>
                    </domain:ns>
                    <domain:registrant>C001</domain:registrant>
                    <domain:contact type="admin">C002</domain:contact>
                    <domain:contact type="tech">C003</domain:contact>
                    <domain:contact type="billing">C004</domain:contact>
                    <domain:authInfo>
                      <domain:pw>' . $auth . '</domain:pw>
                    </domain:authInfo>
                  </domain:create>
                </create>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainCreateFrameDNSSecdsData()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->setPeriod('1y');
        $frame->addHostObj('ns3.' . TEST_DOMAIN);
        $frame->addHostAttr('ns2.' . TEST_DOMAIN);
        $frame->addHostAttr('ns1.' . TEST_DOMAIN, [
            '8.8.8.8',
            '2a00:1450:4009:809::100e',
        ]);
        $frame->setRegistrant('C001');
        $frame->setAdminContact('C002');
        $frame->setTechContact('C003');
        $frame->setBillingContact('C004');
        $auth = $frame->setAuthInfo();
        $frame->addSecDNSdsData(1, 2, 3, 'ABACADAEAF');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <domain:create xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:period unit="y">1</domain:period>
                    <domain:ns>
                      <domain:hostObj>ns3.' . TEST_DOMAIN . '</domain:hostObj>
                      <domain:hostAttr>
                        <domain:hostName>ns2.' . TEST_DOMAIN . '</domain:hostName>
                      </domain:hostAttr>
                      <domain:hostAttr>
                        <domain:hostName>ns1.' . TEST_DOMAIN . '</domain:hostName>
                        <domain:hostAddr ip="v4">8.8.8.8</domain:hostAddr>
                        <domain:hostAddr ip="v6">2a00:1450:4009:809::100e</domain:hostAddr>
                      </domain:hostAttr>
                    </domain:ns>
                    <domain:registrant>C001</domain:registrant>
                    <domain:contact type="admin">C002</domain:contact>
                    <domain:contact type="tech">C003</domain:contact>
                    <domain:contact type="billing">C004</domain:contact>
                    <domain:authInfo>
                      <domain:pw>' . $auth . '</domain:pw>
                    </domain:authInfo>
                  </domain:create>
                </create>
                <extension>
                  <secDNS:create xmlns:secDNS="urn:ietf:params:xml:ns:secDNS-1.1">
                    <secDNS:dsData>
                      <secDNS:keyTag>1</secDNS:keyTag>
                      <secDNS:alg>2</secDNS:alg>
                      <secDNS:digestType>3</secDNS:digestType>
                      <secDNS:digest>ABACADAEAF</secDNS:digest>
                    </secDNS:dsData>
                  </secDNS:create>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainCreateFrameInvalidDomain()
    {
        $frame = new Domain();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setDomain('invalid_domain');
        } else {
            try {
                $frame->setDomain('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }

    public function testDomainCreateFrameInvalidHostObj()
    {
        $frame = new Domain();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->addHostObj('invalid_domain');
        } else {
            try {
                $frame->addHostObj('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
