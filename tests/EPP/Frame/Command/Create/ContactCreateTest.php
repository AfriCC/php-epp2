<?php

namespace AfriCC\Tests\EPP\Frame\Command\Create;

use AfriCC\EPP\Frame\Command\Create\Contact;
use PHPUnit\Framework\TestCase;

class ContactCreateTest extends TestCase
{
    public function testContactCreateFrame()
    {
        $frame = new Contact();
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

        $this->assertXmlStringEqualsXmlString(
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
            </epp>
            ',
            (string) $frame
        );
    }

    public function testContactCreateSkipIntFrame()
    {
        $frame = new Contact();
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

        $this->assertXmlStringEqualsXmlString(
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
            </epp>
            ',
            (string) $frame
        );
    }

    public function testContactCreateSkipLocFrame()
    {
        $frame = new Contact();
        $frame->skipLoc();
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

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <create>
                  <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>CONTACT1</contact:id>
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
            </epp>
            ',
            (string) $frame
        );
    }

    public function testContactCreateDiscloseFrame()
    {
        $frame = new Contact();
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

        $this->assertXmlStringEqualsXmlString(
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
            </epp>
            ',
            (string) $frame
        );
    }

    public function testContactCreateEntities()
    {
        $frame = new Contact();
        $frame->setId('CONTACT1');
        $frame->setOrganization('Fäther & Sons"');

        $this->assertXmlStringEqualsXmlString(
            '
                <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
                  <command>
                    <create>
                      <contact:create xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                        <contact:id>CONTACT1</contact:id>
                        <contact:postalInfo type="loc">
                          <contact:org>Fäther &amp; Sons"</contact:org>
                        </contact:postalInfo>
                        <contact:postalInfo type="int">
                          <contact:org>Father &amp; Sons"</contact:org>
                        </contact:postalInfo>
                      </contact:create>
                    </create>
                  </command>
                </epp>
            ',
            (string) $frame
        );
    }
}
