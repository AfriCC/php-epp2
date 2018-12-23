<?php

namespace AfriCC\Tests\EPP\Frame\Command\Update;

use AfriCC\EPP\Frame\Command\Update\Host;
use PHPUnit\Framework\TestCase;

class HostUpdateTest extends TestCase
{
    public function testUpdateHostFrame()
    {
        $frame = new Host();
        $frame->setHost('ns1.example.com');
        $frame->addAddr('1.1.1.1');
        $frame->removeAddr('8.8.8.8');
        $frame->addAddr('1080:0:0:0:8:800:200C:417A');
        $frame->addStatus('clientUpdateProhibited');
        $frame->removeStatus('clientTransferProhibited');
        $frame->changeHost('ns2.example.com');

        $this->assertXmlStringEqualsXmlString(
            '
                <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
                    <command>
                        <update>
                            <host:update xmlns:host="urn:ietf:params:xml:ns:host-1.0">
                                <host:name>ns1.example.com</host:name>
                                <host:add>
                                    <host:addr ip="v4">1.1.1.1</host:addr>
                                    <host:addr ip="v6">1080:0:0:0:8:800:200C:417A</host:addr>
                                    <host:status s="clientUpdateProhibited"/>
                                </host:add>
                                <host:rem>
                                    <host:addr ip="v4">8.8.8.8</host:addr>
                                    <host:status s="clientTransferProhibited"/>
                                </host:rem>
                                <host:chg>
                                    <host:name>ns2.example.com</host:name>
                                </host:chg>
                            </host:update>
                        </update>
                    </command>
                </epp>
            ',
            (string) $frame
        );
    }
}
