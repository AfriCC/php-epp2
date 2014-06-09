php-epp2
========

**php-epp2** is a EPP high-level client for modern PHP.

It started as a "fork" of [centralnic/php-epp](https://github.com/centralnic/php-epp) which itself is a fork of a older (unfindable?) pear NET::EPP.

Released under the GPLv3 License, feel free to contribute!

Requirements
------------

* PHP 5.4+
* libicu 4.8.x
* php-intl 3.x

Goals
-----

* newer PHP standards
    * autoloader
    * usage of namespaces
    * PSR-1, PSR-2
    * notice and warning free
* added features
    * high-level usage
    * simplified client
    * local cert ssl
    
Future
------
* stricter response parsing
* make a server (in conjunction with mod_epp)