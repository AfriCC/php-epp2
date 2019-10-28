<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Transfer;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Transfer\Future;
use Exception;
use PHPUnit\Framework\TestCase;

class FutureTransferTest extends TestCase
{
    public function testFutureTransferResend()
    {
        $frame = new Future(new NASKObjectSpec());
        $frame->setOperation('request');
        $frame->setFuture(TEST_DOMAIN);
        $frame->setAuthInfo('password');
        $frame->resendConfirmationRequest();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <transfer op="request">
                  <future:transfer xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                    <future:authInfo>
                      <future:pw>password</future:pw>
                    </future:authInfo>
                  </future:transfer>
                </transfer>
                <extension>
                  <extfut:transfer xmlns:extfut="http://www.dns.pl/nask-epp-schema/extfut-2.0">
                    <extfut:resendConfirmationRequest/>
                  </extfut:transfer>
                </extension>
              </command>
            </epp>

            ',
            (string) $frame
            );
    }

    public function testFutureTransferRoid()
    {
        $frame = new Future(new NASKObjectSpec());
        $frame->setOperation('request');
        $frame->setFuture(TEST_DOMAIN);
        $frame->setAuthInfo('password', '1234-NASK');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <transfer op="request">
                  <future:transfer xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
                    <future:name>' . TEST_DOMAIN . '</future:name>
                    <future:authInfo>
                      <future:pw roid="1234-NASK">password</future:pw>
                    </future:authInfo>
                  </future:transfer>
                </transfer>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }

    public function testFutureTransferFrameInvalidFuture()
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
