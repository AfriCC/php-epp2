<?php

namespace AfriCC\Tests\EPP\Frame\Command\Update;

use AfriCC\EPP\Frame\Command\Update\Contact;
use PHPUnit\Framework\TestCase;

class ContactUpdateTest extends TestCase
{
    public function testUpdateContactFrame()
    {
        $frame = new Contact();
        $frame->setId('C0054');
        $frame->addCity('Voerde');
        $frame->addAddStreet('Long St. 14');
        $frame->addAddStreet('CBD');
        $frame->changeAddStreet('Long St. 15');
        $frame->changeCity('Cape Town');
        $frame->removeAddStreet('Long St. 16');
        $frame->removeCity('Durban');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <contact:update xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>C0054</contact:id>
                    <contact:add>
                      <contact:postalInfo type="loc">
                        <contact:addr>
                          <contact:city>Voerde</contact:city>
                          <contact:street>Long St. 14</contact:street>
                          <contact:street>CBD</contact:street>
                        </contact:addr>
                      </contact:postalInfo>
                      <contact:postalInfo type="int">
                        <contact:addr>
                          <contact:city>Voerde</contact:city>
                          <contact:street>Long St. 14</contact:street>
                          <contact:street>CBD</contact:street>
                        </contact:addr>
                      </contact:postalInfo>
                    </contact:add>
                    <contact:chg>
                      <contact:postalInfo type="loc">
                        <contact:addr>
                          <contact:street>Long St. 15</contact:street>
                          <contact:city>Cape Town</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                      <contact:postalInfo type="int">
                        <contact:addr>
                          <contact:street>Long St. 15</contact:street>
                          <contact:city>Cape Town</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                    </contact:chg>
                    <contact:rem>
                      <contact:postalInfo type="loc">
                        <contact:addr>
                          <contact:street>Long St. 16</contact:street>
                          <contact:city>Durban</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                      <contact:postalInfo type="int">
                        <contact:addr>
                          <contact:street>Long St. 16</contact:street>
                          <contact:city>Durban</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                    </contact:rem>
                  </contact:update>
                </update>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testUpdateContactDiscloseFrame()
    {
        $frame = new Contact();
        $frame->setId('C0054');
        $frame->addCity('Voerde');
        $frame->addAddStreet('Long St. 14');
        $frame->addAddStreet('CBD');
        $frame->changeAddStreet('Long St. 15');
        $frame->changeCity('Cape Town');
        $frame->removeAddStreet('Long St. 16');
        $frame->removeCity('Durban');
        $frame->changeAddDisclose('voice', 1);
        $frame->changeAddDisclose('name[@type=\'int\']', 1);

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <update>
                  <contact:update xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
                    <contact:id>C0054</contact:id>
                    <contact:add>
                      <contact:postalInfo type="loc">
                        <contact:addr>
                          <contact:city>Voerde</contact:city>
                          <contact:street>Long St. 14</contact:street>
                          <contact:street>CBD</contact:street>
                        </contact:addr>
                      </contact:postalInfo>
                      <contact:postalInfo type="int">
                        <contact:addr>
                          <contact:city>Voerde</contact:city>
                          <contact:street>Long St. 14</contact:street>
                          <contact:street>CBD</contact:street>
                        </contact:addr>
                      </contact:postalInfo>
                    </contact:add>
                    <contact:chg>
                      <contact:postalInfo type="loc">
                        <contact:addr>
                          <contact:street>Long St. 15</contact:street>
                          <contact:city>Cape Town</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                      <contact:postalInfo type="int">
                        <contact:addr>
                          <contact:street>Long St. 15</contact:street>
                          <contact:city>Cape Town</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                      <contact:disclose flag="1">
                        <contact:voice/>
                        <contact:name type="int"/>
                      </contact:disclose>
                    </contact:chg>
                    <contact:rem>
                      <contact:postalInfo type="loc">
                        <contact:addr>
                          <contact:street>Long St. 16</contact:street>
                          <contact:city>Durban</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                      <contact:postalInfo type="int">
                        <contact:addr>
                          <contact:street>Long St. 16</contact:street>
                          <contact:city>Durban</contact:city>
                        </contact:addr>
                      </contact:postalInfo>
                    </contact:rem>
                  </contact:update>
                </update>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
