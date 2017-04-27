<?php

namespace AfriCC\Tests\EPP\Frame\Command\Info;

use AfriCC\EPP\Frame\Command\Info\Domain;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainInfoTest extends TestCase
{
    public function testDomainInfoFrame()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->setAuthInfo('password');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <info>
                  <domain:info xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name hosts="all">epptest.org</domain:name>
                    <domain:authInfo>
                      <domain:pw>password</domain:pw>
                    </domain:authInfo>
                  </domain:info>
                </info>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainInfoFrameInvalidDomain()
    {
        $frame = new Domain();
        $frame->setAuthInfo('foo', 'bar');

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setDomain('invalid_domain');
        } else {
            try {
                $frame->setDomain('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }

    public function testDomainInfoFrameInvalidReturn()
    {
        $frame = new Domain();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setDomain(TEST_DOMAIN, 'foo');
        } else {
            try {
                $frame->setDomain(TEST_DOMAIN, 'foo');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
