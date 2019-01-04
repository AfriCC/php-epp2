<?php

namespace AfriCC\Tests\EPP\Frame\Command\Transfer;

use AfriCC\EPP\Frame\Command\Transfer\Contact;
use Exception;
use PHPUnit\Framework\TestCase;

class ContactTransferTest extends TestCase
{
    public function testContactTransferFrame()
    {
        $frame = new Contact();
        $frame->setOperation('cancel');
        $frame->setId('sh8013');
        $frame->setAuthInfo('2fooBAR');
        $frame->setClientTransactionId('ABC-12345');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <transfer op="cancel">
                  <contact:transfer
                   xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>sh8013</contact:id>
                    <contact:authInfo>
                      <contact:pw>2fooBAR</contact:pw>
                    </contact:authInfo>
                  </contact:transfer>
                </transfer>
                <clTRID>ABC-12345</clTRID>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testContactTransferFrameInvalidOperation()
    {
        $frame = new Contact();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setOperation('invalid_operation');
        } else {
            try {
                $frame->setOperation('invalid_operation');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
