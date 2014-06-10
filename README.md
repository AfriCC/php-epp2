php-epp2
========

**php-epp2** is a High Level Extensible Provisioning Protocol (EPP) TCP/SSL client written in modern PHP.

It started as a "fork" of [centralnic/php-epp](https://github.com/centralnic/php-epp).

Released under the GPLv3 License, feel free to contribute (fork, create
meaningful branchname, issue pull request with thus branchname)!

**Table of Contents**  *generated with [DocToc](http://doctoc.herokuapp.com/)*

- [php-epp2](#user-content-php-epp2)
    - [Requirements](#user-content-requirements)
    - [Features](#user-content-features)
    - [Usage](#user-content-usage)
        - [Basic Client Connection](#user-content-basic-client-connection)
        - [Create Frame Objects](#user-content-create-frame-objects)
        - [Parse Response](#user-content-parse-response)
    - [Future](#user-content-future)
    - [Credits](#user-content-credits)
    - [Acknowledgments](#user-content-acknowledgments)
    - [License](#user-content-license)


Requirements
------------

* PHP 5.4+
* libicu 4.8.x+
* php-intl 3.x+
* php-mcrypt


Features
--------

* modern PHP standards
    * autoloader (e.g. lazy loading, we don't want to load XXX php files, if we only need few operations)
    * [PSR-1](http://www.php-fig.org/psr/psr-1/) and [PSR-2](http://www.php-fig.org/psr/psr-2/) compliant
    * notice and warning free (find them, and I'll fix it!)
* high-level usage (Plug & Play)
* simplified client (auto login/logout, auto injet clTRID)
* SSL (+local-cert)
* Xpath like setter to simplify the creation of complex XML structures
* XML based responses for direct traversal via Xpath
* [RFC 5730](http://tools.ietf.org/html/rfc5730), [RFC 5731](http://tools.ietf.org/html/rfc5731), [RFC 5732](http://tools.ietf.org/html/rfc5732), [RFC 5733](http://tools.ietf.org/html/rfc5733), [RFC 5734](http://tools.ietf.org/html/rfc5734)


Usage
-----

See the [examples](https://github.com/AfriCC/php-epp2/blob/master/examples) folder
for a complete usage reference.


### Basic Client Connection

this will automatically login on connect() and logout on close()

```php
<?php
require 'src/AfriCC/autoload.php';

use AfriCC\EPP\Client as EPPClient;

$epp_client = new EPPClient([
    'host' => 'epptest.org',
    'username' => 'foo',
    'password' => 'bar',
    'services' => [
        'urn:ietf:params:xml:ns:domain-1.0',
        'urn:ietf:params:xml:ns:contact-1.0'
    ],
    'debug' => true,
]);

try {
    $greeting = $epp_client->connect();
} catch(Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    unset($epp_client);
    exit(1);
}

$epp_client->close();
```


### Create Frame Objects

setXXX() indicates that value can only be set once, re-calling the method will
overwrite the previous value.

addXXX() indicates that multiple values can exist, re-calling the method will
add values.

```php
<?php
require 'src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Create\Host as CreateHost;

$frame = new CreateHost;
$frame->setHost('ns1.example.com');
$frame->setHost('ns2.example.com');
$frame->addAddr('8.8.8.8');
$frame->addAddr('8.8.4.4');
$frame->addAddr('2a00:1450:4009:809::1001');
echo $frame;

// or send frame to previously established connection
$epp_client->sendFrame($frame);
```


### Parse Response

currently you will only get an Object for the type "response"

```php
// @todo
```


Future
------

* stricter response parsing
* make it server capable (in conjunction with mod_epp)


Credits
-------

* [Günter Grodotzki](https://twitter.com/lifeofguenter)
* [All Contributors](https://github.com/AfriCC/php-epp2/graphs/contributors)


Acknowledgments
---------------

* Gavin Brown (original author of Net_EPP)
* [All Contributors of Net_EPP](https://github.com/centralnic/php-epp/graphs/contributors)


License
-------

php-epp2 is released under the GPLv3 License. See the bundled
[LICENSE](https://github.com/AfriCC/php-epp2/blob/master/LICENSE) file for
details.