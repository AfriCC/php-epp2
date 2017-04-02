<?php

namespace AfriCC\Tests\EPP;

use PHPUnit\Framework\TestCase;
use AfriCC\EPP\Translit;

class TranslitTest extends TestCase
{
    public function testUmlaut()
    {
        $umlaut = 'Günter';
        $ascii = 'Gunter';

        $this->assertEquals($ascii, Translit::transliterate($umlaut));
    }
}
