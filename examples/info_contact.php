<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Info\Contact as InfoContact;

$frame = new InfoContact;
$frame->setId('C001');
$frame->setAuthInfo('password');
echo $frame;
