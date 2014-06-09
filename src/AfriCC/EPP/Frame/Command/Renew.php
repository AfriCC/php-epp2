<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

abstract class Renew extends Command
{
    function __construct($type)
    {
        parent::__construct('renew', $type);
    }

    function addObject($object)
    {
        $type = strtolower(str_replace(__CLASS__.'_', '', get_class($this)));
        $this->payload->appendChild($this->createElementNS(
            Net_EPP_ObjectSpec::xmlns($type),
            $type.':'.Net_EPP_ObjectSpec::id($type),
            $object
        ));
    }
}
