<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Prepaid as Report;
use Exception;
use PHPUnit\Framework\TestCase;

class ReportPrepaidTest extends TestCase
{
    public function testPrepaidPaymentsFrame()
    {
        //ObjectSpec::overwriteParent();
        $frame = new Report(new NASKObjectSpec());
        $frame->setPaymentsAccountType('domain');
        $frame->setOffset(0);
        $frame->setLimit(50);
        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<extension>
<extreport:report
xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
<extreport:prepaid>
<extreport:payment>
<extreport:accountType>domain</extreport:accountType>
</extreport:payment>
</extreport:prepaid>
<extreport:offset>0</extreport:offset>
<extreport:limit>50</extreport:limit>
</extreport:report>
</extension>
</epp>
            ',
            (string) $frame
            );
    }

    public function testNaskPrepaidFundsFrame()
    {
        //ObjectSpec::overwriteParent();
        $frame = new Report(new NASKObjectSpec());
        $frame->setFundsAccountType('DOMAIN');
        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<extension>
<extreport:report
xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
<extreport:prepaid>
<extreport:paymentFunds>
<extreport:accountType>DOMAIN</extreport:accountType>
</extreport:paymentFunds>
</extreport:prepaid>
</extreport:report>
</extension>
</epp>
            ',
            (string) $frame
            );
    }

    public function testPrepaidFundsEnumFrame()
    {
        //ObjectSpec::overwriteParent();
        $frame = new Report(new NASKObjectSpec());
        $frame->setFundsAccountType('ENUM');
        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<extension>
<extreport:report
xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
<extreport:prepaid>
<extreport:paymentFunds>
<extreport:accountType>ENUM</extreport:accountType>
</extreport:paymentFunds>
</extreport:prepaid>
</extreport:report>
</extension>
</epp>
            ',
            (string) $frame
            );
    }

    public function testPrepaidFundsInvalidAccount()
    {
        $frame = new Report(new NASKObjectSpec());

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setFundsAccountType('invalid');
        } else {
            try {
                $frame->setFundsAccountType('invalid');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }

    public function testPrepaidPaymentsInvalidAccount()
    {
        $frame = new Report(new NASKObjectSpec());

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setPaymentsAccountType('invalid');
        } else {
            try {
                $frame->setPaymentsAccountType('invalid');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
