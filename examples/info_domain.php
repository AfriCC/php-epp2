<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Info\Domain as InfoDomain;

$frame = new InfoDomain();
$frame->setDomain('example.com', 'all');
echo $frame;
