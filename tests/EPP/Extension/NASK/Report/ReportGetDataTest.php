<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\GetData as Report;
use PHPUnit\Framework\TestCase;

class ReportGetDataTest extends TestCase
{
    public function testReportCancelFrame()
    {
        $frame = new Report(new NASKObjectSpec());
        $frame->setReportId('58ab3bd1-fcce-4c03-b159-8af5f1adb447');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <extension>
                <extreport:report xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
                  <extreport:getData>
                    <extreport:extreportId>58ab3bd1-fcce-4c03-b159-8af5f1adb447</extreport:extreportId>
                  </extreport:getData>
                </extreport:report>
              </extension>
            </epp>
            ',
            (string) $frame
            );
    }
}
