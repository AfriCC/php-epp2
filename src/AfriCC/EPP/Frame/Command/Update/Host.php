<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command\Update;

use AfriCC\EPP\Frame\Command\Update;

class Host extends Update
{
    public function __construct()
    {
        parent::__construct('host');
    }
}
