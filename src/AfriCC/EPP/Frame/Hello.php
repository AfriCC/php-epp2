<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame;

use AfriCC\EPP\AbstractFrame;

final class Hello extends AbstractFrame
{
    protected $format = 'hello';
}
