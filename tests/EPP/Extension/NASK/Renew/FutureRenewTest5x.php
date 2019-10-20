<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Renew;

use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Renew\Future;
use Exception;
use PHPUnit\Framework\TestCase;

class FutureRenewTest5x extends TestCase
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

    public function testFutureRenewReactivate()
    {
        $frame = new Future();
        $frame->setFuture(TEST_DOMAIN);
        $frame->setCurrentExpirationDate('2017-04-25');
        $frame->setPeriod('3y');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <renew>
                  <future:renew xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                    <future:curExpDate>2017-04-25</future:curExpDate>
                    <future:period unit="y">3</future:period>
                  </future:renew>
                </renew>
              </command>
            </epp>
            ',
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
