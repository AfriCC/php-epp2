<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Info\Host as InfoHost;

$frame = new InfoHost;
$frame->setHost('ns1.google.com');
echo $frame;
