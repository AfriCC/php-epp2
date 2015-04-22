<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Transfer\Domain as TransferDomain;

$frame = new TransferDomain;
$frame->setOperation('query');
$frame->setDomain('google.com');
$frame->setAuthInfo('password');
echo $frame;
