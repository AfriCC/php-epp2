<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame\Command\Create;

use AfriCC\EPP\Frame\Command\Create;

class Contact extends Create
{
    public function __construct()
    {
        parent::__construct('contact');
    }
}
