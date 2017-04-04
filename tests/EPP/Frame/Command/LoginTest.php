<?php

namespace AfriCC\Tests\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command\Login;
use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    public function testLoginServices()
    {
        $frame = new Login();
        $frame->setClientId('gunter');
        $frame->setPassword('grodotzki');
        $frame->setNewPassword('grodotzki2');
        $frame->setVersion('1.0');
        $frame->setLanguage('en');
        $frame->addService('urn:ietf:params:xml:ns:domain-1.0');
        $frame->addService('urn:ietf:params:xml:ns:contact-1.0');

        $this->assertXmlStringEqualsXmlString(
            '<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <login>
                  <clID>gunter</clID>
                  <pw>grodotzki</pw>
                  <newPW>grodotzki2</newPW>
                  <options>
                    <version>1.0</version>
                    <lang>en</lang>
                  </options>
                  <svcs>
                    <objURI>urn:ietf:params:xml:ns:domain-1.0</objURI>
                    <objURI>urn:ietf:params:xml:ns:contact-1.0</objURI>
                  </svcs>
                </login>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }

    public function testLoginServicesExtensions()
    {
        $frame = new Login();
        $frame->setClientId('gunter');
        $frame->setPassword('grodotzki');
        $frame->setNewPassword('grodotzki2');
        $frame->setVersion('1.0');
        $frame->setLanguage('en');
        $frame->addService('urn:ietf:params:xml:ns:domain-1.0');
        $frame->addService('urn:ietf:params:xml:ns:contact-1.0');
        $frame->addServiceExtension('http://drs.ua/epp/drs-1.0');
        $frame->addServiceExtension('http://hostmaster.ua/epp/uaepp-1.1');

        $this->assertXmlStringEqualsXmlString(
            '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
            <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
              <command>
                <login>
                  <clID>gunter</clID>
                  <pw>grodotzki</pw>
                  <newPW>grodotzki2</newPW>
                  <options>
                    <version>1.0</version>
                    <lang>en</lang>
                  </options>
                  <svcs>
                    <objURI>urn:ietf:params:xml:ns:domain-1.0</objURI>
                    <objURI>urn:ietf:params:xml:ns:contact-1.0</objURI>
                    <svcExtension>
                      <extURI>http://drs.ua/epp/drs-1.0</extURI>
                      <extURI>http://hostmaster.ua/epp/uaepp-1.1</extURI>
                    </svcExtension>
                  </svcs>
                </login>
              </command>
            </epp>
            ',
            (string) $frame
        );
    }
}
