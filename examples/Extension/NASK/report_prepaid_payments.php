<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Prepaid as ReportPayments;

$frame = new ReportPayments(new NASKObjectSpec());
$frame->setPaymentsAccountType('DOMAIN');
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
