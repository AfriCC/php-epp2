<?php

namespace AfriCC\Tests\EPP\Extension\NICMX\Restore;

use AfriCC\EPP\Extension\NICMX\Restore\Domain;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testNicMxRestoreDomainFrame()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <renew>
                  <nicmx-domrst:restore xmlns:nicmx-domrst="http://www.nic.mx/nicmx-domrst-1.0">
                    <nicmx-domrst:name>' . TEST_DOMAIN . '</nicmx-domrst:name>
                  </nicmx-domrst:restore>
                </renew>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
