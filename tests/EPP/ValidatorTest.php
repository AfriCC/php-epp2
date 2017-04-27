<?php

namespace AfriCC\Tests\EPP;

use AfriCC\EPP\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testGetIPTypeIpv4()
    {
        $this->assertEquals(Validator::TYPE_IPV4, Validator::getIPType('8.8.8.8'));
        $this->assertFalse(Validator::getIPType('0.0.0.0'));
        $this->assertFalse(Validator::getIPType('abc'));
    }

    public function testGetIPTypeIpv6()
    {
        $this->assertEquals(Validator::TYPE_IPV6, Validator::getIPType('2001:4860:4860::8888'));
        $this->assertFalse(Validator::getIPType('::1'));
    }

    public function testIsHostname()
    {
        $this->assertTrue(Validator::isHostname(TEST_DOMAIN));
        $this->assertFalse(Validator::isHostname('google'));
    }

    public function testIsEmail()
    {
        $this->assertTrue(Validator::isEmail('hi@afri.cc'));
        $this->assertTrue(Validator::isEmail('hi+hi@günter.de'));
        $this->assertFalse(Validator::isEmail('@afri.cc'));
        $this->assertFalse(Validator::isEmail('afri.cc'));
    }

    public function testIsCountryCode()
    {
        $this->assertEquals('Cocos (Keeling) Islands', Validator::isCountryCode('cc'));
        $this->assertFalse(Validator::isCountryCode('zz'));
    }
}
