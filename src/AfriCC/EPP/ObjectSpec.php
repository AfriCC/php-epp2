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
    public static $specs = [
        'epp'     => [
            'xmlns' => 'urn:ietf:params:xml:ns:epp-1.0',
        ],
        'domain'  => [
            'xmlns' => 'urn:ietf:params:xml:ns:domain-1.0',
        ],
        'host'    => [
            'xmlns' => 'urn:ietf:params:xml:ns:host-1.0',
        ],
        'contact' => [
            'xmlns' => 'urn:ietf:params:xml:ns:contact-1.0',
        ],
    ];

    public static $mappings = [
        'check', 'create', 'delete', 'info', 'renew', 'transfer', 'update',
    ];

    public static function xmlns($object)
    {
        if (!isset(self::$specs[$object]['xmlns'])) {
            return false;
        }
        return self::$specs[$object]['xmlns'];
    }
}
