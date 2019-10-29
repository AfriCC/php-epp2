<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Delete;

use AfriCC\EPP\Extension\NASK\Delete\Future;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use Exception;
use PHPUnit\Framework\TestCase;

class FutureDeleteTest extends TestCase
{
    public function testFutureDeleteFrame()
    {
        $frame = new Future(new NASKObjectSpec());
        $frame->setFuture(TEST_DOMAIN);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <delete>
                  <future:delete xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                  </future:delete>
                </delete>
              </command>
            </epp>',
            (string) $frame
            );
    }

    public function testFutureDeleteFrameInvalidDomain()
    {
        $frame = new Future(new NASKObjectSpec());

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
