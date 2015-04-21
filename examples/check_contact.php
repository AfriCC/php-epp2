<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Check\Contact as CheckContact;

$frame = new CheckContact;
$frame->addId('sh8013');
$frame->addId('sah8013');
$frame->addId('8013sah');
echo $frame;
