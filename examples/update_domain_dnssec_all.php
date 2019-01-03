<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Update\Domain as UpdateDomain;

$frame = new UpdateDomain();
$frame->setDomain('google.com');
$frame->removeSecDNSAll();
echo $frame;
