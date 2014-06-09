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

class ObjectSpec
{
    const ROOT_NS = 'urn:ietf:params:xml:ns:epp-1.0';

    protected static $specs = array(
        'domain' => array(
            'xmlns' => 'urn:ietf:params:xml:ns:domain-1.0',
            'id'    => 'name',
        ),
        'host' => array(
            'xmlns' => 'urn:ietf:params:xml:ns:host-1.0',
            'id'    => 'name',
        ),
        'contact' => array(
            'xmlns' => 'urn:ietf:params:xml:ns:contact-1.0',
            'id'    => 'id',
        ),
    );

    public static function id($object)
    {
        return self::$specs[$object]['id'];
    }

    public static function xmlns($object)
    {
        return self::$specs[$object]['xmlns'];
    }

    public static function all()
    {
        return self::$specs;
    }
}
