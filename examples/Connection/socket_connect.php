<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../../vendor/autoload.php';

use AfriCC\EPP\Client as EPPClient;

$epp_client = new EPPClient([
    'host' => 'epptest.org',
    'username' => 'gunter',
    'password' => 'grodotzki',
    'services' => [
        'urn:ietf:params:xml:ns:domain-1.0',
        'urn:ietf:params:xml:ns:contact-1.0',
    ],
    'debug' => true,
]);

try {
    $greeting = $epp_client->connect();
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    unset($epp_client);
    exit(1);
}

$epp_client->close();

echo $greeting;
