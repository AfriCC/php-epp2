<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

class Delete extends Command
{
    function __construct($type)
    {
        $this->type = $type;
        parent::__construct('delete', $type);
    }
}
