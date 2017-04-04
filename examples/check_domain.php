<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Check\Domain as CheckDomain;

$frame = new CheckDomain();
$frame->addDomain('example.com');
$frame->addDomain('example.org');
$frame->addDomain('example.net');
echo $frame;
