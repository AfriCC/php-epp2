<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Update\Host as UpdateHost;

$frame = new UpdateHost;
$frame->setHost('ns1.google.com');
$frame->addAddr('8.8.8.8');
$frame->addAddr('2a00:1450:4009:803::1009');
$frame->removeAddr('8.8.4.4');
$frame->removeStatus('clientUpdateProhibited');
$frame->changeHost('ns2.google.com');
echo $frame;
