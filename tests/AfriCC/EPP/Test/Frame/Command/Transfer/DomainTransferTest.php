<?php

namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command\Transfer\Domain as TransferDomain;
use PHPUnit\Framework\TestCase;

class DomainTransferTest extends TestCase
{
    public function testContactCreate()
    {
        $frame = new TransferDomain();
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

    public function testDomainTransferQuery()
    {
        $frame = new TransferDomain();
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
}
