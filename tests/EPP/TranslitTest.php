<?php

namespace AfriCC\Tests\EPP;

use AfriCC\EPP\Translit;
use PHPUnit\Framework\TestCase;

class TranslitTest extends TestCase
{
    public function testUmlaut()
    {
        $umlaut = 'Günter';
        $ascii = 'Gunter';

        $this->assertEquals($ascii, Translit::transliterate($umlaut));
    }
}
