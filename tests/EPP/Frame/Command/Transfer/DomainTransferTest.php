<?php

namespace AfriCC\Tests\EPP\Frame\Command\Transfer;

use AfriCC\EPP\Frame\Command\Transfer\Domain;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainTransferTest extends TestCase
{
    public function testDomainTransferFrame()
    {
        $frame = new Domain();
        $frame->setOperation('cancel');
        $frame->setDomain(TEST_DOMAIN);
        $frame->setPeriod('6y');
        $frame->setAuthInfo('password', 'REP-REP-YEP');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <transfer op="cancel">
                  <domain:transfer xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:period unit="y">6</domain:period>
                    <domain:authInfo>
                      <domain:pw roid="REP-REP-YEP">password</domain:pw>
                    </domain:authInfo>
                  </domain:transfer>
                </transfer>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainTransferFrameQuery()
    {
        $frame = new Domain();
        $frame->setOperation('query');
        $frame->setDomain(TEST_DOMAIN);
        $frame->setAuthInfo('password');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <transfer op="query">
                  <domain:transfer xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:authInfo>
                      <domain:pw>password</domain:pw>
                    </domain:authInfo>
                  </domain:transfer>
                </transfer>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainTransferFrameInvalidDomain()
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

    public function testDomainTransferFrameInvalidOperation()
    {
        $frame = new Domain();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setOperation('invalid_operation');
        } else {
            try {
                $frame->setOperation('invalid_operation');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
