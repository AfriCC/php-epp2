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

/**
 * pseudo random helpers
 */
class Random
{
    /**
     * not so secure, but good enough for client transaction ids
     * @param int $max_length
     * @param string $prefix
     */
    public static function id($max_length = 64, $prefix = '')
    {
        $prefix = (string) $prefix;
        if ($prefix !== '') {
            $prefix .= '-';
        }
        return substr(uniqid($prefix), -$max_length);
    }

    public static function auth($len)
    {
        $rand = mcrypt_create_iv($len, MCRYPT_DEV_URANDOM);
        $rand = base64_encode($rand);
        return substr(rtrim($rand, '='), 0, $len);
    }
}
