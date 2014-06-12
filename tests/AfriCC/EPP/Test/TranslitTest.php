<?php

namespace AfriCC\EPP\Test;

use AfriCC\EPP\Translit;

class TranslitTest extends \PHPUnit_Framework_TestCase
{
    public function testUmlaut()
    {
        $umlaut = 'Günter';
        $ascii  = 'Gunter';

        $this->assertEquals($ascii, Translit::transliterate($umlaut));
    }
}
