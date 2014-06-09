<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command\Info;

use AfriCC\EPP\Frame\Command\Info;

class Contact extends Info
{
    public function __construct()
    {
        parent::__construct('contact');
    }
}
