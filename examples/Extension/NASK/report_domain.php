<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Domain as ReportDomain;

$frame = new ReportDomain(new NASKObjectSpec());
$frame->setState('STATE_REGISTERED');
$frame->setExDate('2007-05-07T11:23:00.0Z');
$frame->addStatus('serverHold');
$frame->setStatusesIn(true);
$frame->addStatus('clientHold');
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
