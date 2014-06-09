<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command\Check;

use AfriCC\EPP\Frame\Command\Check;

class Domain extends Check
{
    public function __construct()
    {
        parent::__construct('domain');
    }
}
