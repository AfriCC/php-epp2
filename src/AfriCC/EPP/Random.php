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
 * Pseudo random helpers.
 */
class Random
{
    /**
     * Not so secure, but good enough for client transaction ids.
     *
     * @param int    $max_length
     * @param string $prefix
     */
    public static function id($max_length = 64, $prefix = '')
    {
        $prefix = (string) $prefix;
        if ($prefix !== '') {
            $prefix .= '-';
        }

        return substr(uniqid($prefix), 0, $max_length);
    }

    /**
     * Generate random auth key.
     *
     * @todo this should be based on templates according to registry requirements!
     *
     * @param int $len
     *
     * @return string
     */
    public static function auth($len)
    {
        // All code bellow does the same - generate as safe as possible random string
        // no need for full coverage test ;)
        // @codeCoverageIgnoreStart
        if (function_exists('random_bytes')) {
            $randomBytes = random_bytes($len);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $randomBytes = openssl_random_pseudo_bytes($len);
        } else {
            $randomBytes = mcrypt_create_iv($len, MCRYPT_DEV_URANDOM);
        }
        // @codeCoverageIgnoreEnd

        $randomBytes = base64_encode($randomBytes);

        return substr(rtrim($randomBytes, '='), 0, $len);
    }
}
