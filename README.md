[![Build Status](https://travis-ci.org/AfriCC/php-epp2.svg?branch=master)](https://travis-ci.org/AfriCC/php-epp2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AfriCC/php-epp2/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AfriCC/php-epp2/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/AfriCC/php-epp2/badge.svg?branch=master)](https://coveralls.io/github/AfriCC/php-epp2?branch=master)
[![Latest Stable Version](https://poser.pugx.org/africc/php-epp2/v/stable.svg)](https://packagist.org/packages/africc/php-epp2)
[![Packagist](https://img.shields.io/packagist/dt/africc/php-epp2.svg)](https://packagist.org/packages/africc/php-epp2)
[![Latest Unstable Version](https://poser.pugx.org/africc/php-epp2/v/unstable.svg)](https://packagist.org/packages/africc/php-epp2)
[![License](https://poser.pugx.org/africc/php-epp2/license.svg)](https://packagist.org/packages/africc/php-epp2)

php-epp2
========

**php-epp2** is a High Level Extensible Provisioning Protocol (EPP) TCP/SSL client written in modern PHP.

Released under the GPLv3 License, feel free to contribute (fork, create
meaningful branchname, issue pull request with thus branchname)!

**Table of Contents**  *generated with [DocToc](http://doctoc.herokuapp.com/)*

- [php-epp2](#user-content-php-epp2)
    - [Requirements](#user-content-requirements)
    - [Features](#user-content-features)
    - [Install](#user-content-install)
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

* PHP 5.5+
* php-ext-intl
* php-ext-openssl


Features
--------

* modern PHP standards
    * [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/) & [PSR-4](http://www.php-fig.org/psr/psr-4/)
    * notice and warning free (find them, and I'll fix it!)
* high-level usage (Plug & Play)
* simplified client for socket and http(s) connections (auto login/logout, auto inject clTRID)
* SSL (+local-cert)
* XPath like setter to simplify the creation of complex XML structures
* XML based responses for direct traversal via XPath
* [RFC 5730](http://tools.ietf.org/html/rfc5730), [RFC 5731](http://tools.ietf.org/html/rfc5731), [RFC 5732](http://tools.ietf.org/html/rfc5732), [RFC 5733](http://tools.ietf.org/html/rfc5733), [RFC 5734](http://tools.ietf.org/html/rfc5734) & [RFC 3915](http://tools.ietf.org/html/rfc3915)
* DNSSEC support [RFC 5910](http://tools.ietf.org/html/rfc5910)


Install
-------

Via Composer

```
$ composer require africc/php-epp2
```


Usage
-----

See the [examples](https://github.com/AfriCC/php-epp2/blob/master/examples)
folder for a more or less complete usage reference. Additionally have a look at 
[whmcs-registrars-coza](https://github.com/AfriCC/whmcs-registrars-coza)
which is a [WHMCS](https://www.whmcs.com) Registrar Module for the
[co.za zone](https://www.registry.net.za) using this library.


### Basic Client Connection

this will automatically login on connect() and logout on close()

```php
<?php
require 'vendor/autoload.php';

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
require 'vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Create\Host as CreateHost;

$frame = new CreateHost();
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

You can either access nodes directly by passing through a xpath or use the data()
Method which will return an assoc array.

```php
use AfriCC\EPP\Frame\Command\Check\Domain as DomainCheck;
use AfriCC\EPP\Frame\Response;

$frame = new DomainCheck();
$frame->addDomain('example.org');
$frame->addDomain('example.net');
$frame->addDomain('example.com');

$response = $epp_client->request($frame);
if (!($response instanceof Response)) {
    echo 'response error' . PHP_EOL;
    unset($epp_client);
    exit(1);
}

$result = $response->results()[0];

echo $result->code() . PHP_EOL;
echo $result->message() . PHP_EOL;
echo $response->clientTransactionId() . PHP_EOL;
echo $response->serverTransactionId() . PHP_EOL;
$data = $response->data();
if (empty($data) || !is_array($data)) {
    echo 'empty response data' . PHP_EOL;
    unset($epp_client);
    exit(1);
}

foreach ($data['chkData']['cd'] as $cd) {
    printf('Domain: %s, available: %d' . PHP_EOL, $cd['name'], $cd['@name']['avail']);
}
```
### Custom ObjectSpec

If registrar you're working with uses custom namespace names (eg NASK) you can 
use custom ObjectSpec. Clients always use specified ObjectSpec when decoding
responses from EPP server.

You can use this feature as follows:

```php
use AfriCC\EPP\HTTPClient as EPPClient;
use \AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Frame\Command\Poll;

$objectSpec = new NASKObjectSpec();
$config = [
    'host' => 'https://app.registrar.tld',
    'username' => 'user',
    'password' => 'pass',
    'services' => $objectSpec->services,
    'serviceExtensions' => $objectSpec->serviceExtensions,
];

$epp_client = new EPPClient($config, $objectSpec);

$frame = new Poll($epp_client->getObjectSpec());
```

or you can create frames with custom ObjectSpec:

```php
use AfriCC\EPP\Extension\NASK\Update\Future as UpdateFuture;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;

$frame = new UpdateFuture(new NASKObjectSpec());
$frame->setFuture('example7.pl');
$frame->changeRegistrant('mak21');
$frame->changeAuthInfo('2fooBAR');
echo $frame;
```

You can also create different clients with different ObjectSpec and then you can
use `getObjectSpec` method when creating any request frame:

```php
use AfriCC\EPP\ObjectSpec as DefaultObjectSpec;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Client as EPPClient;
use AfriCC\EPP\HTTPClient as HTTPEPPClient;
use AfriCC\EPP\Frame\Command\Poll;

//...
$nask_objectspec = new NASKObjectSpec();
$default_objectspec = new DefaultObjectSpec();

$nask_client = new HTTPEPPClient($nask_config, $nask_objectspec);
$http_client = new HTTPEPPClient($http_config, $default_objectspec);
$socket_client = new EPPClient($socket_config, $default_objectspec);
$nask_socket_client = new EPPClient($nask_socket_config, $nask_objectspec);

$nask_poll = new Poll($nask_client->getObjectSpec());
$default_poll = new Poll($socket_client->getObjectSpec());
```

You can also change Client's objectSpec on the fly via `setObjectSpec` method:

```php
use AfriCC\EPP\ObjectSpec as DefaultObjectSpec;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Client as EPPClient;

//...
$nask_objectspec = new NASKObjectSpec();
$default_objectspec = new DefaultObjectSpec();

$variable_client = new EPPClient($socket_config, $default_objectspec);

//calls to getObjectSpec will return default objectSpec and responses
//will be parsed using default ObjectSpec

$variable_client->setObjectSpec($nask_objectspec);

//calls to getObjectSpec will return NASK objectSpec and responses
//will be parsed using NASK ObjectSpec

```

Future
------

* stricter response parsing
* stricter request validation
* make it server capable (in conjunction with apache mod_epp)


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
