<?php
/**
 *
 * @author Gavin Brown <gavin.brown@nospam.centralnic.com>
 * @author Gunter Grodotzki <gunter@afri.cc>
 * @license GPL
 */
namespace AfriCC\EPP;

class ObjectSpec
{
    protected static $_spec = array(
        'domain' => array(
            'xmlns'		=> 'urn:ietf:params:xml:ns:domain-1.0',
            'id'		=> 'name',
            'schema'	=> 'urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd',
        ),
        'host' => array(
            'xmlns'		=> 'urn:ietf:params:xml:ns:host-1.0',
            'id'		=> 'name',
            'schema'	=> 'urn:ietf:params:xml:ns:host-1.0 host-1.0.xsd',
        ),
        'contact' => array(
            'xmlns'		=> 'urn:ietf:params:xml:ns:contact-1.0',
            'id'		=> 'id',
            'schema'	=> 'urn:ietf:params:xml:ns:contact-1.0 contact-1.0.xsd',
        ),
        'rgp' => array(
            'xmlns'		=> 'urn:ietf:params:xml:ns:rgp-1.0',
            'id'		=> 'id',
            'schema'	=> 'urn:ietf:params:xml:ns:rgp-1.0 rgp-1.0.xsd',
        ),
    );

    public static function id($object)
    {
        return self::$_spec[$object]['id'];
    }

    public static function xmlns($object)
    {
        return self::$_spec[$object]['xmlns'];
    }

    public static function schema($object)
    {
        return self::$_spec[$object]['schema'];
    }
}
