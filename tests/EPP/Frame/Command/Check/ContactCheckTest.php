<?php

namespace AfriCC\Tests\EPP\Frame\Command\Check;

use AfriCC\EPP\Frame\Command\Check\Contact as ContactCheck;
use PHPUnit\Framework\TestCase;

class ContactCheckTest extends TestCase
{
    public function testContactCheckFrame()
    {
        $frame = new ContactCheck();
        $frame->addId('handle-1234');
        $this->assertXmlStringEqualsXmlString(
            '<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <check>
                  <contact:check xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>handle-1234</contact:id>
                  </contact:check>
                </check>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
