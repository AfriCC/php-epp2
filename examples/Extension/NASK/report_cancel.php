<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Cancel as ReportCancel;

$frame = new ReportCancel(new NASKObjectSpec());
$frame->setReportId('e264a95d-0ba0-40f1-a0e0-97407fd5cdbe');
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
