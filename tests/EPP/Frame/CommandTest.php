<?php

namespace AfriCC\Tests\EPP\Frame;

use AfriCC\EPP\Frame\Command;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    public function testCommandFrameTrId()
    {
        $frame = $this->getMockForAbstractClass(Command::class);
        $frame->setClientTransactionId('ABC-12345');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <clTRID>ABC-12345</clTRID>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }

    public function testCommandFrameOverlongTrId()
    {
        $frame = $this->getMockForAbstractClass(Command::class);
        $frame->setClientTransactionId('D8O9VI14455H4NTXH6SJ-SYCY00HIFQW76HPVP8CO-FHHFAJ3R76GLZVC6XVX8-I6DR6CQM5LP107ZWPYQO');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <clTRID>D8O9VI14455H4NTXH6SJ-SYCY00HIFQW76HPVP8CO-FHHFAJ3R76GLZVC6XVX8-I</clTRID>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }

    public function testCommandFrameGetTrId()
    {
        $frame = $this->getMockForAbstractClass(Command::class);
        $frame->setClientTransactionId('D8O9VI14455H4NTXH6SJ-SYCY00HIFQW76HPVP8CO-FHHFAJ3R76GLZVC6XVX8-I6DR6CQM5LP107ZWPYQO');

        $clTRID = $frame->getClientTransactionId();

        $this->assertEquals('D8O9VI14455H4NTXH6SJ-SYCY00HIFQW76HPVP8CO-FHHFAJ3R76GLZVC6XVX8-I', $clTRID);
    }
}
