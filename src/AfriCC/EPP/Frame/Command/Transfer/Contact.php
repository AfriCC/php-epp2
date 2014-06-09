<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command\Transfer;

use AfriCC\EPP\Frame\Command\Transfer;

class Contact extends Transfer
{
    public function __construct()
    {
        parent::__construct('contact');
    }
}
