<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Update;

use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Update\Future;
use Exception;
use PHPUnit\Framework\TestCase;

class FutureUpdateTest7x extends TestCase
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

    public function testFutureUpdate()
    {
        $frame = new Future();
        $frame->setFuture(TEST_DOMAIN);
        $frame->changeRegistrant('nsk001');
        $auth = $frame->changeAuthInfo();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <update>
                  <future:update xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                    <future:chg>
                      <future:registrant>nsk001</future:registrant>
                      <future:authInfo>
                        <future:pw>' . $auth . '</future:pw>
                      </future:authInfo>
                    </future:chg>
                  </future:update>
                </update>
              </command>
            </epp>

            ',
            (string) $frame
        );
    }

    public function testFutureUpdateFrameInvalidFuture()
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
