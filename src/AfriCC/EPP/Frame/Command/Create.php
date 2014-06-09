<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

class Create extends Command
{
    protected $command_name = 'create';
    protected $mapping_name;
}
