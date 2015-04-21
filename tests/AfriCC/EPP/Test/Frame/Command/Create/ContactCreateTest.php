<?php

namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command\Create\Contact as CreateContact;

class ContactCreateTest extends \PHPUnit_Framework_TestCase
{
    public function testContactCreate()
    {
        $frame = new CreateContact;
        $frame->setId('CONTACT1');
        $frame->setName('Günter Grodotzki');
        $frame->setName('Jun Grodotzki');
        $frame->setOrganization('weheartwebsites UG');
        $frame->addStreet('Rönskenstraße 23');
        $frame->addStreet('Around the Corner');
        $frame->setCity('Cape Town');
        $frame->setProvince('WC');
        $frame->setPostalCode('8001');
        $frame->setCountryCode('ZA');
        $frame->setVoice('+27.844784784');
        $frame->setFax('+1.844784784');
        $frame->setEmail('github@afri.cc');
        $auth = $frame->setAuthInfo();
        $frame->addDisclose('voice');
        $frame->addDisclose('email');

        $this->assertXmlStringEqualsXmlString((string) $frame,
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>CONTACT1</contact:id>
                    <contact:postalInfo type="loc">
                      <contact:name>Jun Grodotzki</contact:name>
                      <contact:org>weheartwebsites UG</contact:org>
                      <contact:addr>
                        <contact:street>Rönskenstraße 23</contact:street>
                        <contact:street>Around the Corner</contact:street>
                        <contact:city>Cape Town</contact:city>
                        <contact:sp>WC</contact:sp>
                        <contact:pc>8001</contact:pc>
                        <contact:cc>ZA</contact:cc>
                      </contact:addr>
                    </contact:postalInfo>
                    <contact:postalInfo type="int">
                      <contact:name>Jun Grodotzki</contact:name>
                      <contact:org>weheartwebsites UG</contact:org>
                      <contact:addr>
                        <contact:street>Ronskenstrasse 23</contact:street>
                        <contact:street>Around the Corner</contact:street>
                        <contact:city>Cape Town</contact:city>
                        <contact:sp>WC</contact:sp>
                        <contact:pc>8001</contact:pc>
                        <contact:cc>ZA</contact:cc>
                      </contact:addr>
                    </contact:postalInfo>
                    <contact:voice>+27.844784784</contact:voice>
                    <contact:fax>+1.844784784</contact:fax>
                    <contact:email>github@afri.cc</contact:email>
                    <contact:authInfo>
                      <contact:pw>' . $auth . '</contact:pw>
                    </contact:authInfo>
                    <contact:disclose flag="0">
                      <contact:voice/>
                      <contact:email/>
                    </contact:disclose>
                  </contact:create>
                </create>
              </command>
            </epp>'
        );
    }

    public function testContactCreateSkipInt()
    {
        $frame = new CreateContact;
        $frame->skipInt();
        $frame->setId('CONTACT1');
        $frame->setName('Günter Grodotzki');
        $frame->setName('Jun Grodotzki');
        $frame->setOrganization('weheartwebsites UG');
        $frame->addStreet('Rönskenstraße 23');
        $frame->addStreet('Around the Corner');
        $frame->setCity('Cape Town');
        $frame->setProvince('WC');
        $frame->setPostalCode('8001');
        $frame->setCountryCode('ZA');
        $frame->setVoice('+27.844784784');
        $frame->setFax('+1.844784784');
        $frame->setEmail('github@afri.cc');
        $auth = $frame->setAuthInfo();
        $frame->addDisclose('voice');
        $frame->addDisclose('email');

        $this->assertXmlStringEqualsXmlString((string) $frame,
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>CONTACT1</contact:id>
                    <contact:postalInfo type="loc">
                      <contact:name>Jun Grodotzki</contact:name>
                      <contact:org>weheartwebsites UG</contact:org>
                      <contact:addr>
                        <contact:street>Rönskenstraße 23</contact:street>
                        <contact:street>Around the Corner</contact:street>
                        <contact:city>Cape Town</contact:city>
                        <contact:sp>WC</contact:sp>
                        <contact:pc>8001</contact:pc>
                        <contact:cc>ZA</contact:cc>
                      </contact:addr>
                    </contact:postalInfo>
                    <contact:voice>+27.844784784</contact:voice>
                    <contact:fax>+1.844784784</contact:fax>
                    <contact:email>github@afri.cc</contact:email>
                    <contact:authInfo>
                      <contact:pw>' . $auth . '</contact:pw>
                    </contact:authInfo>
                    <contact:disclose flag="0">
                      <contact:voice/>
                      <contact:email/>
                    </contact:disclose>
                  </contact:create>
                </create>
              </command>
            </epp>'
        );
    }

    public function testContactCreateDisclose()
    {
        $frame = new CreateContact;
        $frame->skipInt();
        $frame->setId('CONTACT1');
        $frame->setName('Günter Grodotzki');
        $frame->setOrganization('weheartwebsites UG');
        $frame->addStreet('Rönskenstraße 23');
        $frame->addStreet('Around the Corner');
        $frame->setCity('Cape Town');
        $frame->setProvince('WC');
        $frame->setPostalCode('8001');
        $frame->setCountryCode('ZA');
        $frame->setVoice('+27.844784784');
        $frame->setFax('+1.844784784');
        $frame->setEmail('github@afri.cc');
        $auth = $frame->setAuthInfo();
        $frame->addDisclose('voice', 1);
        $frame->addDisclose('email', 0);

        $this->assertXmlStringEqualsXmlString((string) $frame,
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>CONTACT1</contact:id>
                    <contact:postalInfo type="loc">
                      <contact:name>Günter Grodotzki</contact:name>
                      <contact:org>weheartwebsites UG</contact:org>
                      <contact:addr>
                        <contact:street>Rönskenstraße 23</contact:street>
                        <contact:street>Around the Corner</contact:street>
                        <contact:city>Cape Town</contact:city>
                        <contact:sp>WC</contact:sp>
                        <contact:pc>8001</contact:pc>
                        <contact:cc>ZA</contact:cc>
                      </contact:addr>
                    </contact:postalInfo>
                    <contact:voice>+27.844784784</contact:voice>
                    <contact:fax>+1.844784784</contact:fax>
                    <contact:email>github@afri.cc</contact:email>
                    <contact:authInfo>
                      <contact:pw>' . $auth . '</contact:pw>
                    </contact:authInfo>
                    <contact:disclose flag="1">
                      <contact:voice/>
                    </contact:disclose>
                    <contact:disclose flag="0">
                      <contact:email/>
                    </contact:disclose>
                  </contact:create>
                </create>
              </command>
            </epp>'
        );
    }
}