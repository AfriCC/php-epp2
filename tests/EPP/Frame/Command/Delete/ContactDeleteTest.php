<?php

namespace AfriCC\Tests\EPP\Frame\Command\Delete;

use AfriCC\EPP\Frame\Command\Delete\Contact;
use PHPUnit\Framework\TestCase;

class ContactDeleteTest extends TestCase
{
    public function testContactDeleteFrame()
    {
        $frame = new Contact();
        $frame->setId('C001');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <delete>
                  <contact:delete xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>C001</contact:id>
                  </contact:delete>
                </delete>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
