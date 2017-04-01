<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Poll;

$frame = new Poll();
$frame->request();
echo $frame;

echo PHP_EOL;

$frame = new Poll();
$frame->ack('FMS-EPP-12A18BE965E-6D25E');
echo $frame;
