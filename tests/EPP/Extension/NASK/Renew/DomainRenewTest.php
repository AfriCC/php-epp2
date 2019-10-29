<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Renew;

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Renew\Domain;
use PHPUnit\Framework\TestCase;

class DomainRenewTest extends TestCase
{
    public function testDomainRenewReactivate()
    {
        $frame = new Domain(new NASKObjectSpec());
        $frame->setDomain(TEST_DOMAIN);
        $frame->setCurrentExpirationDate('2017-04-25');
        $frame->setPeriod('1y');
        $frame->setReactivate();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <renew>
                  <domain:renew xmlns:domain="http://www.dns.pl/nask-epp-schema/domain-2.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:curExpDate>2017-04-25</domain:curExpDate>
                    <domain:period unit="y">1</domain:period>
                  </domain:renew>
                </renew>
                <extension>
                  <extdom:renew xmlns:extdom="http://www.dns.pl/nask-epp-schema/extdom-2.0">
                    <extdom:reactivate/>
                  </extdom:renew>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }

    public function testDomainRenewToDate()
    {
        $frame = new Domain(new NASKObjectSpec());
        $frame->setDomain(TEST_DOMAIN);
        $frame->setCurrentExpirationDate('2012-09-15');
        $frame->setRenewToDate('2012-09-25');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <renew>
                  <domain:renew xmlns:domain="http://www.dns.pl/nask-epp-schema/domain-2.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:curExpDate>2012-09-15</domain:curExpDate>
                  </domain:renew>
                </renew>
                <extension>
                  <extdom:renew xmlns:extdom="http://www.dns.pl/nask-epp-schema/extdom-2.0">
                    <extdom:renewToDate>2012-09-25</extdom:renewToDate >
                  </extdom:renew>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }
}
