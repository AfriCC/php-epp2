<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Report;

ObjectSpec::overwriteParent();

$frame = new Report();
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
