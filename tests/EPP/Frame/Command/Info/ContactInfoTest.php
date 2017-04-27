<?php

namespace AfriCC\Tests\EPP\Frame\Command\Info;

use AfriCC\EPP\Frame\Command\Info\Contact;
use PHPUnit\Framework\TestCase;

class ContactInfoTest extends TestCase
{
    public function testContactInfoFrame()
    {
        $frame = new Contact();
        $frame->setId('C001');
        $frame->setAuthInfo('password');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <info>
                  <contact:info xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>C001</contact:id>
                    <contact:authInfo>
                      <contact:pw>password</contact:pw>
                    </contact:authInfo>
                  </contact:info>
                </info>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
