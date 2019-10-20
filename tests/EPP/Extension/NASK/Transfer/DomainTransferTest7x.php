<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Transfer;

use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Transfer\Domain;
use PHPUnit\Framework\TestCase;

class DomainTransferTest7x extends TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        ObjectSpec::overwriteParent();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        ObjectSpec::restoreParent();
        parent::tearDown();
    }

    public function testDomainTransferResend()
    {
        $frame = new Domain();
        $frame->setOperation('request');
        $frame->setDomain(TEST_DOMAIN);
        $frame->setAuthInfo('password');
        $frame->resendConfirmationRequest();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <transfer op="request">
                  <domain:transfer xmlns:domain="http://www.dns.pl/nask-epp-schema/domain-2.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:authInfo>
                      <domain:pw>password</domain:pw>
                    </domain:authInfo>
                  </domain:transfer>
                </transfer>
                <extension>
                  <extdom:transfer xmlns:extdom="http://www.dns.pl/nask-epp-schema/extdom-2.0">
                    <extdom:resendConfirmationRequest/>
                  </extdom:transfer>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }
}
