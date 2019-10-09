<?php

namespace AfriCC\Tests\EPP\Extension\NicIT\Info;

use AfriCC\EPP\Extension\NicIT\Info\Domain;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testNicItInfoDomainFrame()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->setInfContacts('all');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <info>
                  <domain:info xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name hosts="all">' . TEST_DOMAIN . '</domain:name>
                  </domain:info>
                </info>
                <extension>
                  <extdom:infContacts xmlns:extdom="http://www.nic.it/ITNIC-EPP/extdom-2.0" op="all"/>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
