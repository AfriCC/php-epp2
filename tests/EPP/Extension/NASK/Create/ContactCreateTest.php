<?php

namespace AfriCC\Tests\EPP\Extension\NASK\Create;

use AfriCC\EPP\Extension\NASK\Create\Contact;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use PHPUnit\Framework\TestCase;

class ContactCreateTest extends TestCase
{
    public function testContactCreateFrame()
    {
        $frame = new Contact(new NASKObjectSpec());
        $frame->skipInt();
        $frame->setId('sh8013');
        $frame->setName('John Doe');
        $frame->addStreet('123 Example Dr.');
        $frame->addStreet('Suite 100');
        $frame->setCity('Dulles');
        $frame->setProvince('VA');
        $frame->setPostalCode('20166-6503');
        $frame->setCountryCode('US');
        $frame->setVoice('+1.7035555555', 1234);
        $frame->setFax('+1.7035555556');
        $frame->setEmail('jdoe@example.tld');
        $auth = $frame->setAuthInfo();
        $frame->setIndividual(true);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<command>
<create>
<contact:create
xmlns:contact="http://www.dns.pl/nask-epp-schema/contact-2.0">
<contact:id>sh8013</contact:id>
<contact:postalInfo type="loc">
<contact:name>John Doe</contact:name>
<contact:addr>
<contact:street>123 Example Dr.</contact:street>
<contact:street>Suite 100</contact:street>
<contact:city>Dulles</contact:city>
<contact:sp>VA</contact:sp>
<contact:pc>20166-6503</contact:pc>
<contact:cc>US</contact:cc>
</contact:addr>
</contact:postalInfo>
<contact:voice x="1234">+1.7035555555</contact:voice>
<contact:fax>+1.7035555556</contact:fax>
<contact:email>jdoe@example.tld</contact:email>
<contact:authInfo>
<contact:pw>' . $auth . '</contact:pw>
</contact:authInfo>
</contact:create>
</create>
<extension>
<extcon:create
xmlns:extcon="http://www.dns.pl/nask-epp-schema/extcon-2.0">
<extcon:individual>1</extcon:individual>
</extcon:create>
</extension>
</command>
</epp>',
            (string) $frame
        );
    }

    public function testContactCreateFrameOrganization()
    {
        $frame = new Contact(new NASKObjectSpec());
        $frame->skipInt();
        $frame->setId('sh8013');
        $frame->setName('John Doe');
        $frame->setOrganization('php-epp2');
        $frame->addStreet('123 Example Dr.');
        $frame->addStreet('Suite 100');
        $frame->setCity('Dulles');
        $frame->setProvince('VA');
        $frame->setPostalCode('20166-6503');
        $frame->setCountryCode('US');
        $frame->setVoice('+1.7035555555', 1234);
        $frame->setFax('+1.7035555556');
        $frame->setEmail('jdoe@example.tld');
        $auth = $frame->setAuthInfo();
        $frame->setIndividual(false);
        $frame->setConsentForPublishing(true);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<epp xmlns="http://www.dns.pl/nask-epp-schema/epp-2.0">
<command>
<create>
<contact:create
xmlns:contact="http://www.dns.pl/nask-epp-schema/contact-2.0">
<contact:id>sh8013</contact:id>
<contact:postalInfo type="loc">
<contact:name>John Doe</contact:name>
<contact:org>php-epp2</contact:org>
<contact:addr>
<contact:street>123 Example Dr.</contact:street>
<contact:street>Suite 100</contact:street>
<contact:city>Dulles</contact:city>
<contact:sp>VA</contact:sp>
<contact:pc>20166-6503</contact:pc>
<contact:cc>US</contact:cc>
</contact:addr>
</contact:postalInfo>
<contact:voice x="1234">+1.7035555555</contact:voice>
<contact:fax>+1.7035555556</contact:fax>
<contact:email>jdoe@example.tld</contact:email>
<contact:authInfo>
<contact:pw>' . $auth . '</contact:pw>
</contact:authInfo>
</contact:create>
</create>
<extension>
<extcon:create
xmlns:extcon="http://www.dns.pl/nask-epp-schema/extcon-2.0">
<extcon:individual>0</extcon:individual>
<extcon:consentForPublishing>1</extcon:consentForPublishing>
</extcon:create>
</extension>
</command>
</epp>',
            (string) $frame
            );
    }
}
