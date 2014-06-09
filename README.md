php-epp2
========

**php-epp2** is a EPP high-level TCP client written in modern PHP.

It started as a "fork" of [centralnic/php-epp](https://github.com/centralnic/php-epp).

Released under the GPLv3 License, feel free to contribute!

Requirements
------------

* PHP 5.4+
* libicu 4.8.x
* php-intl 3.x

Features
--------

* modern PHP standards
    * autoloader
    * [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/) compliant
    * notice and warning free
* high-level usage
* simplified client
* SSL (+local-cert)
* XML based responses for direct traversal via xpath

Usage
-----


    
Future
------

* stricter response parsing
* make it server capable (in conjunction with mod_epp)


Credits
-------

* [Günter Grodotzki](https://twitter.com/lifeofguenter)

Acknowledgments
---------------

* Gavin Brown (original author of Net_EPP)


License
-------

php-epp2 is released under the GPLv3 License. See the bundled
[LICENSE](https://github.com/AfriCC/php-epp2/blob/master/LICENSE) file for
details.