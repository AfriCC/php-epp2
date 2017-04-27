<?php

namespace AfriCC\Tests\EPP\Frame\Command\Check;

use AfriCC\EPP\Frame\Command\Check\Host as HostCheck;
use Exception;
use PHPUnit\Framework\TestCase;

class HostCheckTest extends TestCase
{
    public function testHostCheckFrame()
    {
        $frame = new HostCheck();
        $frame->addHost('ns1.' . TEST_DOMAIN);
        $this->assertXmlStringEqualsXmlString(
            '<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <check>
                  <host:check xmlns:host="urn:ietf:params:xml:ns:host-1.0">
                    <host:name>ns1.' . TEST_DOMAIN . '</host:name>
                  </host:check>
                </check>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testHostCheckFrameInvalidHost()
    {
        $frame = new HostCheck();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->addHost('invalid_host');
        } else {
            try {
                $frame->addHost('invalid_host');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
