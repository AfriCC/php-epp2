<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Info;

use AfriCC\EPP\Extension\NASK\Info\Future;
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use Exception;
use PHPUnit\Framework\TestCase;

class FutureInfoTest5x extends TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        ObjectSpec::overwriteParent();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        ObjectSpec::restoreParent();
        parent::tearDown();
    }

    public function testFutureInfoFrame()
    {
        $frame = new Future();
        $frame->setFuture(TEST_DOMAIN);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <info>
                  <future:info xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                  </future:info>
                </info>
              </command>
            </epp>',
            (string) $frame
            );
    }

    public function testFutureInfoFrameAuthinfo()
    {
        $frame = new Future();
        $frame->setFuture(TEST_DOMAIN);
        $frame->setAuthInfo('password');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <info>
                  <future:info xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                    <future:authInfo>
                      <future:pw>password</future:pw>
                    </future:authInfo>
                  </future:info>
                </info>
              </command>
            </epp>',
            (string) $frame
            );
    }

    public function testFutureInfoFrameAuthinfoRoid()
    {
        $frame = new Future();
        $frame->setFuture(TEST_DOMAIN);
        $frame->setAuthInfo('password', 'nsk1234');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <info>
                  <future:info xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                    <future:authInfo>
                      <future:pw roid="nsk1234">password</future:pw>
                    </future:authInfo>
                  </future:info>
                </info>
              </command>
            </epp>',
            (string) $frame
            );
    }

    public function testFutureInfoFrameInvalidDomain()
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
