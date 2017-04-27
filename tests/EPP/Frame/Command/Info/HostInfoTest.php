<?php

namespace AfriCC\Tests\EPP\Frame\Command\Info;

use AfriCC\EPP\Frame\Command\Info\Host;
use Exception;
use PHPUnit\Framework\TestCase;

class HostInfoTest extends TestCase
{
    public function testHostInfoFrame()
    {
        $frame = new Host();
        $frame->setHost('ns1.' . TEST_DOMAIN);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <info>
                  <host:info xmlns:host="urn:ietf:params:xml:ns:host-1.0">
                    <host:name>ns1.' . TEST_DOMAIN . '</host:name>
                  </host:info>
                </info>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testHostInfoFrameInvalidHost()
    {
        $frame = new Host();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setHost('invalid_domain');
        } else {
            try {
                $frame->setHost('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
