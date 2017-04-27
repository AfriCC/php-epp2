<?php

namespace AfriCC\Tests\EPP\Frame\Command\Check;

use AfriCC\EPP\Frame\Command\Check\Domain as DomainCheck;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainCheckTest extends TestCase
{
    public function testDomainCheckFrame()
    {
        $frame = new DomainCheck();
        $frame->addDomain(TEST_DOMAIN);
        $this->assertXmlStringEqualsXmlString(
            '<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <check>
                  <domain:check xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                  </domain:check>
                </check>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainCheckFrameInvalidDomain()
    {
        $frame = new DomainCheck();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->addDomain('invalid_domain');
        } else {
            try {
                $frame->addDomain('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
