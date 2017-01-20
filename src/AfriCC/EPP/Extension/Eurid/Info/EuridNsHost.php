<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 1/19/17
 * Time: 3:22 PM
 */

namespace AfriCC\EPP\Extension\Eurid\Info;

use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Create\Host as CreateNsHost;
use AfriCC\EPP\ObjectSpec;

class EuridNsHost extends CreateNsHost implements ExtensionInterface
{
    protected $extension_xmlns = 'http://www.eurid.eu/xml/epp/nsgroup-1.1';

    public function setNsGroupName($name)
    {
        ObjectSpec::$specs += [
            'nsgroup' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        $this->set("//epp:epp/epp:command/epp:info/nsgroup:info/nsgroup:name", $name);
    }

    public function setNsGroupNs(array $nsArr)
    {
        ObjectSpec::$specs += [
            'nsgroup' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        foreach ($nsArr as $ns) {
            $this->set("//epp:epp/epp:command/epp:info/nsgroup:info/nsgroup:ns", $ns);
        }
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }

}