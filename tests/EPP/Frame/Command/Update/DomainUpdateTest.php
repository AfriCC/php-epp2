<?php

namespace AfriCC\Tests\EPP\Frame\Command\Update;

use AfriCC\EPP\Frame\Command\Update\Domain;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainUpdateTest extends TestCase
{
    public function testDomainUpdateFrame()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->addAdminContact('ADMIN-2');
        $frame->addTechContact('TECH-2');
        $frame->addBillingContact('BILL-2');
        $frame->removeAdminContact('ADMIN-1');
        $frame->removeTechContact('TECH-1');
        $frame->removeBillingContact('BILL-1');
        $frame->addHostObj('ns1.' . TEST_DOMAIN);
        $frame->addHostAttr('ns2.' . TEST_DOMAIN, [
            '8.8.8.8',
            '2a00:1450:4009:809::100e',
        ]);
        $frame->removeHostObj('ns3.' . TEST_DOMAIN);
        $frame->removeHostAttr('ns4.' . TEST_DOMAIN);
        $frame->addStatus('clientHold', 'Payment overdue.');
        $frame->removeStatus('clientDeleteProhibited');
        $auth = $frame->changeAuthInfo();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:add>
                      <domain:contact type="admin">ADMIN-2</domain:contact>
                      <domain:contact type="tech">TECH-2</domain:contact>
                      <domain:contact type="billing">BILL-2</domain:contact>
                      <domain:ns>
                        <domain:hostObj>ns1.' . TEST_DOMAIN . '</domain:hostObj>
                        <domain:hostAttr>
                          <domain:hostName>ns2.' . TEST_DOMAIN . '</domain:hostName>
                          <domain:hostAddr ip="v4">8.8.8.8</domain:hostAddr>
                          <domain:hostAddr ip="v6">2a00:1450:4009:809::100e</domain:hostAddr>
                        </domain:hostAttr>
                      </domain:ns>
                      <domain:status s="clientHold" lang="en">Payment overdue.</domain:status>
                    </domain:add>
                    <domain:rem>
                      <domain:contact type="admin">ADMIN-1</domain:contact>
                      <domain:contact type="tech">TECH-1</domain:contact>
                      <domain:contact type="billing">BILL-1</domain:contact>
                      <domain:ns>
                        <domain:hostObj>ns3.' . TEST_DOMAIN . '</domain:hostObj>
                        <domain:hostAttr>
                          <domain:hostName>ns4.' . TEST_DOMAIN . '</domain:hostName>
                        </domain:hostAttr>
                      </domain:ns>
                      <domain:status s="clientDeleteProhibited" />
                    </domain:rem>
                    <domain:chg>
                      <domain:authInfo>
                        <domain:pw>' . $auth . '</domain:pw>
                      </domain:authInfo>
                    </domain:chg>
                  </domain:update>
                </update>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainUpdateFrameChangeRegistrar()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->changeRegistrant('C005');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:chg>
                      <domain:registrant>C005</domain:registrant>
                    </domain:chg>
                  </domain:update>
                </update>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }

    public function testDomainUpdateFrameDNSSecdsData()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->addAdminContact('ADMIN-1');
        $frame->addTechContact('TECH-2');
        $frame->addHostObj('ns1.' . TEST_DOMAIN);
        $frame->addHostAttr('ns2.' . TEST_DOMAIN, [
            '8.8.8.8',
            '2a00:1450:4009:809::100e',
        ]);
        $frame->removeHostAttr('ns3.' . TEST_DOMAIN);
        $frame->addStatus('clientHold', 'Payment overdue.');
        $auth = $frame->changeAuthInfo();

        //RFC 5910 - order: first remove, then add
        $frame->removeSecDNSdsData(1, 2, 3, 'AABBCCDDEEFF');
        $frame->addSecDNSdsData(2, 4, 9, 'ABACADAFA0');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:add>
                      <domain:contact type="admin">ADMIN-1</domain:contact>
                      <domain:contact type="tech">TECH-2</domain:contact>
                      <domain:ns>
                        <domain:hostObj>ns1.' . TEST_DOMAIN . '</domain:hostObj>
                        <domain:hostAttr>
                          <domain:hostName>ns2.' . TEST_DOMAIN . '</domain:hostName>
                          <domain:hostAddr ip="v4">8.8.8.8</domain:hostAddr>
                          <domain:hostAddr ip="v6">2a00:1450:4009:809::100e</domain:hostAddr>
                        </domain:hostAttr>
                      </domain:ns>
                      <domain:status s="clientHold" lang="en">Payment overdue.</domain:status>
                    </domain:add>
                    <domain:rem>
                      <domain:ns>
                        <domain:hostAttr>
                          <domain:hostName>ns3.' . TEST_DOMAIN . '</domain:hostName>
                        </domain:hostAttr>
                      </domain:ns>
                    </domain:rem>
                    <domain:chg>
                      <domain:authInfo>
                        <domain:pw>' . $auth . '</domain:pw>
                      </domain:authInfo>
                    </domain:chg>
                  </domain:update>
                </update>
                <extension>
                  <secDNS:update xmlns:secDNS="urn:ietf:params:xml:ns:secDNS-1.1">
                    <secDNS:rem>
                      <secDNS:dsData>
                        <secDNS:keyTag>1</secDNS:keyTag>
                        <secDNS:alg>2</secDNS:alg>
                        <secDNS:digestType>3</secDNS:digestType>
                        <secDNS:digest>AABBCCDDEEFF</secDNS:digest>
                      </secDNS:dsData>
                    </secDNS:rem>
                    <secDNS:add>
                      <secDNS:dsData>
                        <secDNS:keyTag>2</secDNS:keyTag>
                        <secDNS:alg>4</secDNS:alg>
                        <secDNS:digestType>9</secDNS:digestType>
                        <secDNS:digest>ABACADAFA0</secDNS:digest>
                      </secDNS:dsData>
                    </secDNS:add>
                  </secDNS:update>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainUpdateFrameRemoveDNSSecdsData()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->removeSecDNSAll();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                  </domain:update>
                </update>
                <extension>
                  <secDNS:update xmlns:secDNS="urn:ietf:params:xml:ns:secDNS-1.1">
                    <secDNS:rem>
                      <secDNS:all>true</secDNS:all>
                    </secDNS:rem>
                  </secDNS:update>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainUpdateFrameInvalidDomain()
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

    public function testDomainUpdateFrameInvalidHostObj()
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
