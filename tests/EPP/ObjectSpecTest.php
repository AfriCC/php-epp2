<?php

namespace AfriCC\Tests\EPP;

use AfriCC\EPP\ObjectSpec;
use AfriCC\EPP\Random;
use PHPUnit\Framework\TestCase;

/**
 * ObjectSpec test case.
 */
class ObjectSpecTest extends TestCase
{
    /**
     * Tests ObjectSpec->xmlns()
     */
    public function testXmlnsTrue()
    {
        $objectSpec = new ObjectSpec();
        $objects = array_keys($objectSpec->specs);
        foreach ($objects as $object) {
            $this->assertEquals($objectSpec->specs[$object]['xmlns'], $objectSpec->xmlns($object));
        }
    }

    public function testXmlnsFalse()
    {
        $objectSpec = new ObjectSpec();
        $randomId = Random::auth(32);
        while (isset($objectSpec->specs[$randomId])) {
            $randomId = Random::auth(32); //make sure randomId is not in xmlns specs
        }
        $this->assertFalse($objectSpec->xmlns($randomId));
    }
}
