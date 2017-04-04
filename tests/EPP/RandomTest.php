<?php

namespace AfriCC\Tests\EPP;

use AfriCC\EPP\Random;
use PHPUnit\Framework\TestCase;

class RandomTest extends TestCase
{
    const PREFIX = 'prefix';
    const AUTH_LEN = 32;

    public function testId()
    {
        $randomId = Random::id(64, static::PREFIX);

        $this->assertStringStartsWith(static::PREFIX, $randomId);
        $this->assertEquals(13 + strlen(static::PREFIX) + 1, strlen($randomId));
    }

    public function testAuth()
    {
        $this->assertEquals(static::AUTH_LEN, strlen(Random::auth(static::AUTH_LEN)));
    }
}
