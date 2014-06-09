<?php
/**
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

class Delete extends Command
{
    protected $command_name = 'delete';
    protected $mapping_name;
}
