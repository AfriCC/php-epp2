<?php

namespace AfriCC\Tests\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command\Logout;
use PHPUnit\Framework\TestCase;

class LogoutTest extends TestCase
{
    public function testLogoutFrame()
    {
        $frame = new Logout();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <logout/>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
