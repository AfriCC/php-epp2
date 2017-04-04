<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Check\Host as CheckHost;

$frame = new CheckHost();
$frame->addHost('ns1.example.com');
$frame->addHost('ns2.example.com');
$frame->addHost('ns3.example.com');
echo $frame;
