<?php

namespace AfriCC\Tests\EPP\DOM;

use AfriCC\EPP\DOM\DOMElement;
use PHPUnit\Framework\TestCase;
use DOMDocument;

class DOMElementTest extends TestCase
{
    public function testHasChildNodes()
    {
        $dom = new DOMDocument('1.0', 'utf-8');

        $parent = new DOMElement('foo');
        $dom->appendChild($parent);
        $this->assertFalse($parent->hasChildNodes());

        $child = new DOMElement('bar');
        $parent->appendChild($child);
        $this->assertTrue($parent->hasChildNodes());
    }
}
