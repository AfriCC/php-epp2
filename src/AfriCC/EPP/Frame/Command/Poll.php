<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

abstract class Poll extends Command
{
    function __construct()
    {
        parent::__construct('poll');
    }

    function setOp($op)
    {
        $this->command->setAttribute('op', $op);
    }
}
