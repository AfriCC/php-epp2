<?php

namespace AfriCC\Tests\EPP\Extension\NASK;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report;
use PHPUnit\Framework\TestCase;

class ReportTest extends TestCase
{
    public function testNaskReportFrame()
    {
        $frame = new Report(new NASKObjectSpec());
        $frame->setOffset(0);
        $frame->setLimit(50);
        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<extension>
<extreport:report
xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
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
