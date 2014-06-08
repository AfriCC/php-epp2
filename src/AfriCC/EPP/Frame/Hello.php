<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame;

use AfriCC\EPP\Frame;

final class Hello extends Frame
{
    function __construct()
    {
        parent::__construct('hello');
    }
}
