<?php

namespace AfriCC\Tests\EPP\Frame\Command\Delete;

use AfriCC\EPP\Frame\Command\Delete\Host;
use Exception;
use PHPUnit\Framework\TestCase;

class HostDeleteTest extends TestCase
{
    public function testHostDeleteFrame()
    {
        $frame = new Host();
        $frame->setHost('ns1.' . TEST_DOMAIN);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <delete>
                  <host:delete xmlns:host="urn:ietf:params:xml:ns:host-1.0">
                    <host:name>ns1.' . TEST_DOMAIN . '</host:name>
                  </host:delete>
                </delete>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testHostDeleteFrameInvalidHost()
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
