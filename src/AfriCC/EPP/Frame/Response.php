<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP\Frame;

use AfriCC\EPP\Frame;

final class Response extends Frame
{
    function __construct()
    {
        parent::__construct('response');
    }

    function code()
    {
        return $this->getElementsByTagName('result')->item(0)->getAttribute('code');
    }

    function message()
    {
        return $this->getElementsByTagName('msg')->item(0)->firstChild->textContent;
    }
}
