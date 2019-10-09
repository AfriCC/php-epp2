<?php

namespace AfriCC\Tests\EPP\Extension\NicIT\Create;

use AfriCC\EPP\Extension\NicIT\Create\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testNicItCreateContactFrame()
    {
        $frame = new Contact();
        $frame->skipInt();
        $frame->setId('BES000001');
        $frame->setName('Riccardo Bessone');
        $frame->setOrganization('Consul S.r.l.');
        $frame->addStreet('Corso Massimo d\'Azeglio 57');
        $frame->setCity('Torino');
        $frame->setProvince('TO');
        $frame->setPostalCode('10067');
        $frame->setCountryCode('TO');
        $frame->setVoice('+39.123456789');
        $frame->setEmail('riccardo@bess.one');
        $auth = $frame->setAuthInfo();
        $frame->setConsentForPublishing(true);
        $frame->setRegistrant(1, 'IT', 'IT123456789');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>BES000001</contact:id>
                    <contact:postalInfo type="loc">
                      <contact:name>Riccardo Bessone</contact:name>
                      <contact:org>Consul S.r.l.</contact:org>
                      <contact:addr>
                        <contact:street>Corso Massimo d\'Azeglio 57</contact:street>
                        <contact:city>Torino</contact:city>
                        <contact:sp>TO</contact:sp>
                        <contact:pc>10067</contact:pc>
                        <contact:cc>TO</contact:cc>
                      </contact:addr>
                    </contact:postalInfo>
                    <contact:voice>+39.123456789</contact:voice>
                    <contact:email>riccardo@bess.one</contact:email>
                    <contact:authInfo>
                      <contact:pw>' . $auth . '</contact:pw>
                    </contact:authInfo>
                  </contact:create>
                </create>
                <extension>
                  <extcon:create xmlns:extcon="http://www.nic.it/ITNIC-EPP/extcon-1.0">
                    <extcon:consentForPublishing>true</extcon:consentForPublishing>
                    <extcon:registrant>
                      <extcon:entityType>1</extcon:entityType>
                      <extcon:nationalityCode>IT</extcon:nationalityCode>
                      <extcon:regCode>IT123456789</extcon:regCode>
                    </extcon:registrant>
                  </extcon:create>
                </extension>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
