<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Create\Host as CreateHost;

$frame = new CreateHost;
$frame->setName('ns1.example.com');
$frame->setName('ns2.example.com');
$frame->addAddr('8.8.8.8');
$frame->addAddr('8.8.4.4');
$frame->addAddr('2a00:1450:4009:809::1001');
echo $frame;
