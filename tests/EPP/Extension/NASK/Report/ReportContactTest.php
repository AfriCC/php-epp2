<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Contact as Report;
use PHPUnit\Framework\TestCase;

class ReportContactTest extends TestCase
{
    public function testReportContactFrame()
    {
        $frame = new Report(new NASKObjectSpec());

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <extension>
                <extreport:report xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
                  <extreport:contact />
                </extreport:report>
              </extension>
            </epp>
            ',
            (string) $frame
            );
    }

    public function testReportSpecificContactFrame()
    {
        $frame = new Report(new NASKObjectSpec());
        $frame->setContactId('k13');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <extension>
                <extreport:report xmlns:extreport="http://www.dns.pl/nask-epp-schema/extreport-2.0">
                  <extreport:contact>
                    <extreport:conId>k13</extreport:conId>
                  </extreport:contact>
                </extreport:report>
              </extension>
            </epp>
            ',
            (string) $frame
            );
    }
}
