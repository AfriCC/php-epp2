<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Transfer\Contact as TransferContact;

$frame = new TransferContact;
$frame->setOperation('request');
$frame->setId('C001');
$frame->setAuthInfo('password');
echo $frame;
