<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Update;

use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Update\Contact;
use PHPUnit\Framework\TestCase;

class ContactUpdateTest7x extends TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        ObjectSpec::overwriteParent();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown(): void
    {
        ObjectSpec::restoreParent();
        parent::tearDown();
    }

    public function testContactUpdateIndividual()
    {
        $frame = new Contact();
        $frame->setId('sh8013');
        $frame->setIndividual(true);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <update>
                  <contact:update xmlns:contact="http://www.dns.pl/nask-epp-schema/contact-2.0">
                    <contact:id>sh8013</contact:id>
                  </contact:update>
                </update>
                <extension>
                  <extcon:update xmlns:extcon="http://www.dns.pl/nask-epp-schema/extcon-2.0">
                    <extcon:individual>1</extcon:individual>
                  </extcon:update>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testContactUpdateConsent()
    {
        $frame = new Contact();
        $frame->setId('sh8013');
        $frame->setConsentForPublishing(false);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <update>
                  <contact:update xmlns:contact="http://www.dns.pl/nask-epp-schema/contact-2.0">
                    <contact:id>sh8013</contact:id>
                  </contact:update>
                </update>
                <extension>
                  <extcon:update xmlns:extcon="http://www.dns.pl/nask-epp-schema/extcon-2.0">
                    <extcon:consentForPublishing>0</extcon:consentForPublishing>
                  </extcon:update>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
            );
    }
}
