<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Create;

use AfriCC\EPP\Extension\NASK\Create\Future;
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use Exception;
use PHPUnit\Framework\TestCase;

class FutureCreateTest7x extends TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        ObjectSpec::overwriteParent();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        ObjectSpec::restoreParent();
        parent::tearDown();
    }

    public function testFutureCreateFrame()
    {
        $frame = new Future();
        $frame->setFuture(TEST_DOMAIN);
        $frame->setPeriod('3y');
        $frame->setRegistrant('nsk1234');
        $auth = $frame->setAuthInfo();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <create>
                  <future:create xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                    <future:period unit="y">3</future:period>
                    <future:registrant>nsk1234</future:registrant>
                    <future:authInfo>
                      <future:pw>' . $auth . '</future:pw>
                    </future:authInfo>
                  </future:create>
                </create>
              </command>
            </epp>',
            (string) $frame
            );
    }

    public function testFutureCreateFrameInvalidDomain()
    {
        $frame = new Future();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setFuture('invalid_domain');
        } else {
            try {
                $frame->setFuture('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
