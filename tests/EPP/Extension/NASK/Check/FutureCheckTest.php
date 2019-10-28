<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Check;

use AfriCC\EPP\Extension\NASK\Check\Future as FutureCheck;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Future test case.
 */
class FutureCheckTest extends TestCase
{
    /**
     * Tests Future->addFuture()
     */
    public function testAddFuture()
    {
        $frame = new FutureCheck(new NASKObjectSpec());
        $frame->addFuture(TEST_DOMAIN);
        $frame->addFuture('przyklad1.pl');
        $frame->addFuture('przyklad2.pl');
        $frame->setClientTransactionId('ABC-12345');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<command>
<check>
<future:check
xmlns:future="http://www.dns.pl/nask-epp-schema/future-2.0">
<future:name>' . TEST_DOMAIN . '</future:name>
<future:name>przyklad1.pl</future:name>
<future:name>przyklad2.pl</future:name>
</future:check>
</check>
<clTRID>ABC-12345</clTRID>
</command>
</epp>
            ',
            (string) $frame
            );
    }

    public function testDomainCheckFrameInvalidDomain()
    {
        $frame = new FutureCheck(new NASKObjectSpec());

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->addFuture('invalid_domain');
        } else {
            try {
                $frame->addFuture('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
