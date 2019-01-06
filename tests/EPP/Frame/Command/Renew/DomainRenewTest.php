<?php

namespace AfriCC\Tests\EPP\Frame\Command\Renew;

use AfriCC\EPP\Frame\Command\Renew\Domain;
use Exception;
use PHPUnit\Framework\TestCase;

class DomainRenewTest extends TestCase
{
    public function testDomainRenewFrame()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);
        $frame->setCurrentExpirationDate('2017-04-25');
        $frame->setPeriod('1y');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <renew>
                  <domain:renew xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:curExpDate>2017-04-25</domain:curExpDate>
                    <domain:period unit="y">1</domain:period>
                  </domain:renew>
                </renew>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testDomainRenewFrameInvalidDomain()
    {
        $frame = new Domain();

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setDomain('invalid_domain');
        } else {
            try {
                $frame->setDomain('invalid_domain');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }

    public function testDomainRenewFrameInvalidPeriod()
    {
        $frame = new Domain();
        $frame->setDomain(TEST_DOMAIN);

        if (method_exists($this, 'expectException')) {
            $this->expectException(Exception::class);
            $frame->setCurrentExpirationDate('2017-04-25');
            $frame->setPeriod('1');
        } else {
            try {
                $frame->setCurrentExpirationDate('2017-04-25');
                $frame->setPeriod('1');
            } catch (Exception $e) {
                $this->assertEquals('Exception', get_class($e));
            }
        }
    }
}
