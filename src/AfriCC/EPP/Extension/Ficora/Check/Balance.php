<?php
namespace AfriCC\EPP\Extension\Ficora\Check;

use AfriCC\EPP\ExtensionInterface;
use AfriCC\EPP\Frame\Command\Check\Domain;

/**
 * Created by IntelliJ IDEA.
 * User: nikolayyotsov
 * Date: 3/6/17
 * Time: 10:51 AM
 */
class Balance extends Domain implements ExtensionInterface
{
    protected $extension_xmlns = 'urn:ietf:params:xml:ns:epp-1.0';

    public function checkBalance()
    {
        $this->set("//epp:epp/epp:command/epp:check/balance");
    }

    public function getExtensionNamespace()
    {
        return $this->extension_xmlns;
    }
}