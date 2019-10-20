<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Info;

use AfriCC\EPP\Extension\NASK\Info\Contact;
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use PHPUnit\Framework\TestCase;

class ContactInfoTest5x extends TestCase
{
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        ObjectSpec::overwriteParent();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        ObjectSpec::restoreParent();
        parent::tearDown();
    }

    public function testContactInfoFrameAuthinfo()
    {
        $frame = new Contact();
        $frame->setId('666666');
        $frame->setAuthInfo('2fooBAR');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <info>
                  <contact:info xmlns:contact="http://www.dns.pl/nask-epp-schema/contact-2.0">
                    <contact:id>666666</contact:id>
                  </contact:info>
                </info>
                <extension>
                  <extcon:info xmlns:extcon="http://www.dns.pl/nask-epp-schema/extcon-2.0">
                    <extcon:authInfo>
                      <extcon:pw>2fooBAR</extcon:pw>
                    </extcon:authInfo>
                  </extcon:info>
                </extension>
              </command>
            </epp>',
            (string) $frame
            );
    }

    public function testFutureInfoFrameAuthinfoRoid()
    {
        $frame = new Contact();
        $frame->setId('666666');
        $frame->setAuthInfo('2fooBAR', '1234-NASK');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
              <command>
                <info>
                  <contact:info xmlns:contact="http://www.dns.pl/nask-epp-schema/contact-2.0">
                    <contact:id>666666</contact:id>
                  </contact:info>
                </info>
                <extension>
                  <extcon:info xmlns:extcon="http://www.dns.pl/nask-epp-schema/extcon-2.0">
                    <extcon:authInfo>
                      <extcon:pw roid="1234-NASK">2fooBAR</extcon:pw>
                    </extcon:authInfo>
                  </extcon:info>
                </extension>
              </command>
            </epp>',
            (string) $frame
            );
    }
}
