<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\GetData as ReportGetData;

ObjectSpec::overwriteParent();

$frame = new ReportGetData();
$frame->setReportId('58ab3bd1-fcce-4c03-b159-8af5f1adb447');
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
