<?php
/**
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

abstract class Poll extends Command
{
    protected $command_name = 'poll';

    protected function setOp($op)
    {
        $this->command->setAttribute('op', $op);
    }
}
