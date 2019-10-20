<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Host as ReportHost;

ObjectSpec::overwriteParent();

$frame = new ReportHost();
$frame->setName('ns1.temp.pl');
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
