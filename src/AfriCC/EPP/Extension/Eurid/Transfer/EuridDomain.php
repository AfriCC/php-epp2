<?php
/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 1/19/17
 * Time: 3:22 PM
 */

namespace AfriCC\EPP\Extension\Eurid\Transfer;


use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Transfer\Domain;
use AfriCC\EPP\ObjectSpec;


class EuridDomain extends Domain implements ExtensionInterface
{
    protected $extension_xmlns = 'http://www.eurid.eu/xml/epp/domain-ext-2.1';

    public function setTransfer($handle, $contactType)
    {
        ObjectSpec::$specs += [
            'domain-ext' => [
                'xmlns' => $this->extension_xmlns,
            ],
        ];

        $this->set('//epp:epp/epp:command/epp:extension/domain-ext:transfer/domain-ext:request/domain-ext:contact[@type=\''.$contactType.'\']', $handle);
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}