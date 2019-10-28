<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Create;

use AfriCC\EPP\Extension\NASK\Create\Domain;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainCreateTest extends TestCase
{
    public function testDomainCreateFrame()
    {
        $frame = new Domain(new NASKObjectSpec());
        $frame->setDomain(TEST_DOMAIN);
        $frame->setPeriod('1y');
        $frame->addNs('ns1.' . TEST_DOMAIN);
        $frame->addHostObj('ns2.' . TEST_DOMAIN);
        $frame->setRegistrant('nsk1234');
        $frame->setAdminContact('C002');
        $frame->setTechContact('C003');
        $frame->setBillingContact('C004');
        $auth = $frame->setAuthInfo();
        $frame->setBook();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<command>
<create>
<domain:create
xmlns:domain="http://www.dns.pl/nask-epp-schema/domain-2.0">
<domain:name>' . TEST_DOMAIN . '</domain:name>
<domain:period unit="y">1</domain:period>
<domain:ns>ns1.' . TEST_DOMAIN . '</domain:ns>
<domain:ns>ns2.' . TEST_DOMAIN . '</domain:ns>
<domain:registrant>nsk1234</domain:registrant>
<domain:authInfo>
<domain:pw>' . $auth . '</domain:pw>
</domain:authInfo>
</domain:create>
</create>
<extension>
<extdom:create
xmlns:extdom="http://www.dns.pl/nask-epp-schema/extdom-2.0">
<extdom:book/>
</extdom:create>
</extension>
</command>
</epp>',
            (string) $frame
        );
    }

    public function testDomainCreateFrameInvalidHostObj()
    {
        $frame = new Domain(new NASKObjectSpec());

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->addHostObj('invalid_domain');
        } else {
            try {
                $frame->addHostObj('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
