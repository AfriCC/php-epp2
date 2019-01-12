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
        'epp' => [
            'xmlns' => 'urn:ietf:params:xml:ns:epp-1.0',
        ],
        'domain' => [
            'xmlns' => 'urn:ietf:params:xml:ns:domain-1.0',
        ],
        'host' => [
            'xmlns' => 'urn:ietf:params:xml:ns:host-1.0',
        ],
        'contact' => [
            'xmlns' => 'urn:ietf:params:xml:ns:contact-1.0',
        ],
        'secDNS' => [
            'xmlns' => 'urn:ietf:params:xml:ns:secDNS-1.1',
        ],
    ];

    public static $mappings = [
        'check', 'create', 'delete', 'info', 'renew', 'transfer', 'update',
    ];

    public static function xmlns($object)
    {
        if (!isset(static::$specs[$object]['xmlns'])) {
            return false;
        }

        return static::$specs[$object]['xmlns'];
    }
}
