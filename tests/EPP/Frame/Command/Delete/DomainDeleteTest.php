<?php

namespace AfriCC\Tests\EPP\Frame\Command\Delete;

use AfriCC\EPP\Frame\Command\Delete\Domain;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainDeleteTest extends TestCase
{
    public function testDomainDeleteFrame()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <delete>
                  <domain:delete xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                  </domain:delete>
                </delete>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainDeleteFrameInvalidDomain()
    {
        $frame = new Domain();

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
}
