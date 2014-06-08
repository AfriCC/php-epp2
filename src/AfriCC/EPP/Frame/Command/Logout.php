<?php
/**
 * @link http://tools.ietf.org/html/rfc5730#section-2.9.1.2
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command;

use AfriCC\EPP\Frame\Command;

class Logout extends Command
{
    public function __construct()
    {
        parent::__construct('logout');
    }
}