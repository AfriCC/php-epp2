<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../../vendor/autoload.php';

use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Frame\Command\Poll;
use AfriCC\EPP\HTTPClient as EPPClient;

$objectSpec = new NASKObjectSpec();
$config = [
    'debug' => true,
    'host' => 'https://app.registrar.tld',
    'username' => 'user',
    'password' => 'pass',
    'services' => $objectSpec->services,
    'serviceExtensions' => $objectSpec->serviceExtensions,
    //'ssl' => true, //ssl forced to true by using "https" protocol
    'ca_cert' => 'ca.crt',
    'local_cert' => 'client.crt',
    'pk_cert' => 'client.key',
];

$epp_client = new EPPClient($config, $objectSpec);

try {
    $greeting = $epp_client->connect();

    echo $greeting;

    $frame = new Poll($epp_client->getObjectSpec()); //use epp client default objectspec
    $frame->request();

    $response = $epp_client->request($frame);

    while ($response->success() && $response->code() !== 1300) { // 1300 = result successful, no more mesages

        echo 'Epp Poll message ID: ';
        echo $response->queueId();
        echo "\n";
        echo 'Epp Poll Message: ';
        echo $response->queueMessage();

        $ackFrame = new Poll($epp_client->getObjectSpec());
        $ackFrame->ack($response->queueId());
        $ackResponse = $epp_client->request($ackFrame);
        if (!$ackResponse->success()) {
            echo "Couldn't ACK poll message\n";
            break; // no ack!
        }
        $response = $client->request($frame); //reuse already existing poll request frame
    }
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
    unset($epp_client);
    exit(1);
}

$epp_client->close();
