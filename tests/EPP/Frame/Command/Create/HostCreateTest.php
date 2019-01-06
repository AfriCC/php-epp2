<?php

namespace AfriCC\Tests\EPP\Frame\Command\Create;

use AfriCC\EPP\Frame\Command\Create\Host;
use Exception;
use PHPUnit\Framework\TestCase;

class HostCreateTest extends TestCase
{
    public function testHostCreateFrame()
    {
        $frame = new Host();
        $frame->setHost('ns1.' . TEST_DOMAIN);
        $frame->addAddr('8.8.8.8');
        $frame->addAddr('2a00:1450:4009:809::100e');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <host:create xmlns:host="urn:ietf:params:xml:ns:host-1.0">
                    <host:name>ns1.' . TEST_DOMAIN . '</host:name>
                    <host:addr ip="v4">8.8.8.8</host:addr>
                    <host:addr ip="v6">2a00:1450:4009:809::100e</host:addr>
                  </host:create>
                </create>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testHostCreateFrameInvalidHost()
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

    public function testHostCreateFrameInvalidHostIp()
    {
        $frame = new Host();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setHost('ns1.' . TEST_DOMAIN);
            $frame->addAddr('invalidip');
        } else {
            try {
                $frame->setHost('ns1.' . TEST_DOMAIN);
                $frame->addAddr('invalidip');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
