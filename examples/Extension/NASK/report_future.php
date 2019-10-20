<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Future as ReportFuture;

ObjectSpec::overwriteParent();

$frame = new ReportFuture();
$frame->setExDate('2007-04-23T15:22:34.0Z');
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
