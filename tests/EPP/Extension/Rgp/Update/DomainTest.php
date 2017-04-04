<?php

namespace AfriCC\Tests\EPP\Extension\Rgp\Update;

use AfriCC\EPP\Extension\Rgp\Update\Domain;
use PHPUnit\Framework\TestCase;

class DomainTest extends TestCase
{
    public function testRestoreRequestFrame()
    {
        $frame = new Domain();
        $frame->changeDomain(TEST_DOMAIN);
        $frame->restoreRequest();

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:chg/>
                  </domain:update>
                </update>
                <extension>
                  <rgp:update xmlns:rgp="urn:ietf:params:xml:ns:rgp-1.0">
                    <rgp:restore op="request"/>
                  </rgp:update>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testRestoreReportFrame()
    {
        $frame = new Domain();
        $frame->addDomain(TEST_DOMAIN);
        $frame->restoreReport();
        $frame->setPreData('Pre-delete registration data goes here. Both XML and free text are allowed.');
        $frame->setPostData('Post-restore registration data goes here. Both XML and free text are allowed.');
        $frame->setDelTime('2003-07-10T22:00:00.0Z');
        $frame->setResTime('2003-07-20T22:00:00.0Z');
        $frame->setResReason('Registrant error.');
        $frame->addStatement('This registrar has not restored the Registered Name in order to assume the rights to use or sell the Registered Name for itself or for anythird party.');
        $frame->addStatement('The information in this report is true to best of this registrar\'s knowledge, and this registrar acknowledges that intentionally supplying false information in this report shall constitute an incurable material breach of the Registry-Registrar Agreement.');
        $frame->setOther('Supporting information goes here.');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <domain:update xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
                    <domain:name>' . TEST_DOMAIN . '</domain:name>
                    <domain:add/>
                  </domain:update>
                </update>
                <extension>
                  <rgp:update xmlns:rgp="urn:ietf:params:xml:ns:rgp-1.0">
                    <rgp:restore op="report">
                      <rgp:report>
                        <rgp:preData>Pre-delete registration data goes here. Both XML and free text are allowed.</rgp:preData>
                        <rgp:postData>Post-restore registration data goes here. Both XML and free text are allowed.</rgp:postData>
                        <rgp:delTime>2003-07-10T22:00:00.0Z</rgp:delTime>
                        <rgp:resTime>2003-07-20T22:00:00.0Z</rgp:resTime>
                        <rgp:resReason>Registrant error.</rgp:resReason>
                        <rgp:statement>This registrar has not restored the Registered Name in order to assume the rights to use or sell the Registered Name for itself or for anythird party.</rgp:statement>
                        <rgp:statement>The information in this report is true to best of this registrar\'s knowledge, and this registrar acknowledges that intentionally supplying false information in this report shall constitute an incurable material breach of the Registry-Registrar Agreement.</rgp:statement>
                        <rgp:other>Supporting information goes here.</rgp:other>
                      </rgp:report>
                    </rgp:restore>
                  </rgp:update>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
