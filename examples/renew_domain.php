<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Renew\Domain as RenewDomain;

$frame = new RenewDomain;
$frame->setDomain('google.com');
$frame->setCurrentExpirationDate(date('Y-m-d'));
$frame->setPeriod('6m');
echo $frame;
