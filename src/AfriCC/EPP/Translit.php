<?php

/**
 * This file is part of the php-epp2 library.
 *
 * (c) Gunter Grodotzki <gunter@afri.cc>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

namespace AfriCC\EPP;

class Translit
{
    public static function transliterate($string)
    {
        // the reason for using this rather "exotic" function in contrary to
        // iconv is, that iconv is very unstable. It relies on the correct
        // linked library, which means it works different on OSX than on Linux
        // also iconv + setlocale is not thread safe, so if you are using IIS
        // php-fpm, fastcgi or similar it can/will break
        return transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0100-\u7fff] remove', $string);
    }
}
