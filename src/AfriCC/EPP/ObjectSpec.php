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
 * EPP object definitions and xml namespaces
 */
class ObjectSpec
{
    protected static $specs = [
        'epp'     => [
            'xmlns' => 'urn:ietf:params:xml:ns:epp-1.0',
            'id'    => 'name',
        ],
        'domain'  => [
            'xmlns' => 'urn:ietf:params:xml:ns:domain-1.0',
            'id'    => 'name',
        ],
        'host'    => [
            'xmlns' => 'urn:ietf:params:xml:ns:host-1.0',
            'id'    => 'name',
        ],
        'contact' => [
            'xmlns' => 'urn:ietf:params:xml:ns:contact-1.0',
            'id'    => 'id',
        ],
    ];

    public static function id($object)
    {
        return self::$specs[$object]['id'];
    }

    public static function xmlns($object)
    {
        if (!isset(self::$specs[$object]['xmlns'])) {
            return false;
        }
        return self::$specs[$object]['xmlns'];
    }

    public static function all()
    {
        return self::$specs;
    }
}
