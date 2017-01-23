<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 1/19/17
 * Time: 3:22 PM
 */

namespace AfriCC\EPP\Extension\Eurid\Create;


use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Create\Domain as CreateDomain;
use AfriCC\EPP\ObjectSpec;


class EuridDomain extends CreateDomain implements ExtensionInterface
{
    protected $extension_xmlns = 'http://www.eurid.eu/xml/epp/domain-ext-2.1';

    public function setContact($handle, $type)
    {
        if ('onsite' == $type) {
            $this->setContactOnSite($handle);
            return;
        }

        $this->set('domain:contact[@type=\'' . $type . '\']', $handle);
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }


    protected function setContactOnSite($handle)
    {
        ObjectSpec::$specs += [
            'domain-ext' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        $this->set('//epp:epp/epp:command/epp:extension/domain-ext:create/domain-ext:contact[@type=\'onsite\']', $handle);
    }
}