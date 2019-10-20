<?php

namespace AfriCC\Tests\EPP\Extension\Nominet\Release;

use AfriCC\EPP\Extension\Nominet\Release\Domain as DomainRelease;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function test()
    {
        $tag = 'EXAMPLE-TAG';

        $frame = new DomainRelease();
        $frame->setDomain(TEST_DOMAIN);
        $frame->setRegistrarTag('EXAMPLE-TAG');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <r:release xmlns:r="http://www.nominet.org.uk/epp/xml/std-release-1.0">
                    <r:domainName>' . TEST_DOMAIN . '</r:domainName>
                    <r:registrarTag>' . $tag . '</r:registrarTag>
                  </r:release>
                </update>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
