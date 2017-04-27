<?php

namespace AfriCC\Tests\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command\Poll;
use PHPUnit\Framework\TestCase;

class PollTest extends TestCase
{
    public function testPollFrameRequest()
    {
        $frame = new Poll();
        $frame->request();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <poll op="req"/>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testPollFrameAck()
    {
        $frame = new Poll();
        $frame->ack('msg-id-1234');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <poll op="ack" msgID="msg-id-1234"/>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
