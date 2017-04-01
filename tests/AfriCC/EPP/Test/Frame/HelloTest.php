<?php

namespace AfriCC\EPP\Frame;

use PHPUnit\Framework\TestCase;

class HelloTest extends TestCase
{
    public function testHelloFrame()
    {
        $frame = new Hello();

        $this->assertXmlStringEqualsXmlString(
            (string) $frame,
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <hello/>
            </epp>
            '
        );
    }
}
