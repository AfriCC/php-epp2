<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Report;

use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Contact as Report;
use PHPUnit\Framework\TestCase;

class ReportContactTest5x extends TestCase
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

    public function testReportContactFrame()
    {
        $frame = new Report();

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
        $frame = new Report();
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
