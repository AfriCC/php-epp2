<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Domain as Report;
use PHPUnit\Framework\TestCase;

class ReportDomainTest extends TestCase
{
    public function testDomainReportFrame()
    {
        //ObjectSpec::overwriteParent();
        $frame = new Report(new NASKObjectSpec());
        $frame->setState('STATE_REGISTERED');
        $frame->setExDate('2007-05-07T11:23:00.0Z');
        $frame->setStatusesIn(true);
        $frame->addStatus('serverHold');
        $frame->setOffset(0);
        $frame->setLimit(50);
        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<extension>
<extreport:report
xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
<extreport:domain>
<extreport:state>STATE_REGISTERED</extreport:state>
<extreport:exDate>2007-05-07T11:23:00.0Z</extreport:exDate>
<extreport:statuses statusesIn="true">
<extreport:status>serverHold</extreport:status>
</extreport:statuses>
</extreport:domain>
<extreport:offset>0</extreport:offset>
<extreport:limit>50</extreport:limit>
</extreport:report>
</extension>
</epp>
            ',
            (string) $frame
            );
    }
}
