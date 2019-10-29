<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Create;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Update\Domain;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainUpdateTest extends TestCase
{
    public function testDomainUpdateFrame()
    {
        $frame = new Domain(new NASKObjectSpec());
        $frame->setDomain(TEST_DOMAIN);
        $frame->addNs('ns1.' . TEST_DOMAIN);
        $frame->removeHostObj('ns2.' . TEST_DOMAIN);
        $frame->addAdminContact('C012');
        $frame->addTechContact('C013');
        $frame->addBillingContact('C014');
        $frame->removeAdminContact('C002');
        $frame->removeTechContact('C003');
        $frame->removeBillingContact('C004');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <update>
                  <domain:update xmlns:domain="http://www.dns.pl/nask-epp-schema/domain-2.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:add>
                      <domain:ns>ns1.' . TEST_DOMAIN . '</domain:ns>
                    </domain:add>
                    <domain:rem>
                      <domain:ns>ns2.' . TEST_DOMAIN . '</domain:ns>
                      <domain:contact type="admin">C002</domain:contact>
                      <domain:contact type="tech">C003</domain:contact>
                      <domain:contact type="billing">C004</domain:contact>
                    </domain:rem>
                  </domain:update>
                </update>
              </command>
            </epp>
',
            (string) $frame
            );
    }

    public function testDomainUpdateFrameRemovesInvalidNs()
    {
        $frame = new Domain(new NASKObjectSpec());

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->removeNs('invalid_domain');
        } else {
            try {
                $frame->removeNs('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
