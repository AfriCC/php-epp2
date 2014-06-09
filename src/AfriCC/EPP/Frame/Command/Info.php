<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

abstract class Info extends Command
{
    function __construct($type)
    {
        parent::__construct('info', $type);
    }

    function setObject($object)
    {
        $type = strtolower(str_replace(__CLASS__.'_', '', get_class($this)));
        foreach ($this->payload->childNodes as $child) $this->payload->removeChild($child);
        $this->payload->appendChild($this->createElementNS(
            Net_EPP_ObjectSpec::xmlns($type),
            $type.':'.Net_EPP_ObjectSpec::id($type),
            $object
        ));
    }

    function setAuthInfo($authInfo)
    {
        $el = $this->createObjectPropertyElement('authInfo');
        $el->appendChild($this->createObjectPropertyElement('pw'));
        $el->firstChild->appendChild($this->createTextNode($authInfo));
        $this->payload->appendChild($el);
    }
}
