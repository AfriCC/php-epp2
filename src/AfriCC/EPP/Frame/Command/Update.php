<?php
/**
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

class Update extends Command
{
    protected $command_name = 'update';
    protected $mapping_name;
}
