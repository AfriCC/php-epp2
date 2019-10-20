<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Cancel as Report;
use PHPUnit\Framework\TestCase;

class ReportCancelTest5x extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        ObjectSpec::overwriteParent();
    }

    public function tearDown()
    {
        ObjectSpec::restoreParent();
    }

    public function testReportCancelFrame()
    {
        //ObjectSpec::overwriteParent();
        $frame = new Report();
        $frame->setReportId('e264a95d-0ba0-40f1-a0e0-97407fd5cdbe');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <extension>
                <extreport:report xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
                  <extreport:cancel>
                    <extreport:extreportId>e264a95d-0ba0-40f1-a0e0-97407fd5cdbe</extreport:extreportId>
                  </extreport:cancel>
                </extreport:report>
              </extension>
            </epp>
            ',
            (string) $frame
            );
    }
}
