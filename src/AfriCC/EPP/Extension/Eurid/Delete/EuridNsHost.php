<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 1/19/17
 * Time: 3:22 PM
 */

namespace AfriCC\EPP\Extension\Eurid\Delete;

use AfriCC\EPP\ExtensionInterface;

use AfriCC\EPP\Frame\Command\Delete\Host;
use AfriCC\EPP\ObjectSpec;

class EuridNsHost extends Host implements ExtensionInterface
{
    protected $extension_xmlns = 'http://www.eurid.eu/xml/epp/nsgroup-1.1';

    public function setNsGroupName($name)
    {
        ObjectSpec::$specs += [
            'nsgroup' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        $this->set("//epp:epp/epp:command/epp:delete/nsgroup:delete/nsgroup:name", $name);
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }

}