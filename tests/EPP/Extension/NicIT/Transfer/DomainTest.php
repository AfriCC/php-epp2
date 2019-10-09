<?php

namespace AfriCC\Tests\EPP\Extension\NicIT\Transfer;

use AfriCC\EPP\Extension\NicIT\Transfer\Domain;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testDomainTransferFrame()
    {
        $frame = new Domain();
        $frame->setOperation('request');
        $frame->setDomain(TEST_DOMAIN);
        $frame->setAuthInfo('password');
        $frame->setNewRegistrant('BES0000001');
        $frame->setNewAuthInfo('new-password');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <transfer op="request">
                  <domain:transfer xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:authInfo>
                      <domain:pw>password</domain:pw>
                    </domain:authInfo>
                  </domain:transfer>
                </transfer>
                <extension>
                  <extdom:trade xmlns:extdom="http://www.nic.it/ITNIC-EPP/extdom-2.0">
                    <extdom:transferTrade>
                      <extdom:newRegistrant>BES0000001</extdom:newRegistrant>
                      <extdom:newAuthInfo>
                        <extdom:pw>new-password</extdom:pw>
                      </extdom:newAuthInfo>
                    </extdom:transferTrade>
                  </extdom:trade>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
