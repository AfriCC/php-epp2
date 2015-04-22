<?php

namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command\Transfer\Domain as TransferDomain;

class DomainTransferTest extends \PHPUnit_Framework_TestCase
{
    public function testContactCreate()
    {
        $frame = new TransferDomain;
        $frame->setOperation('cancel');
        $frame->setDomain('google.com');
        $frame->setPeriod('6y');
        $frame->setAuthInfo('password', 'REP-REP-YEP');

        $this->assertXmlStringEqualsXmlString((string) $frame,
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <transfer op="cancel">
                  <domain:transfer xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>google.com</domain:name>
                    <domain:period unit="y">6</domain:period>
                    <domain:authInfo>
                      <domain:pw roid="REP-REP-YEP">password</domain:pw>
                    </domain:authInfo>
                  </domain:transfer>
                </transfer>
              </command>
            </epp>'
        );
    }

    public function testDomainTransferQuery()
    {
        $frame = new TransferDomain;
        $frame->setOperation('query');
        $frame->setDomain('google.com');
        $frame->setAuthInfo('password');

        $this->assertXmlStringEqualsXmlString((string) $frame,
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <transfer op="query">
                  <domain:transfer xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>google.com</domain:name>
                    <domain:authInfo>
                      <domain:pw>password</domain:pw>
                    </domain:authInfo>
                  </domain:transfer>
                </transfer>
              </command>
            </epp>'
        );
    }
}