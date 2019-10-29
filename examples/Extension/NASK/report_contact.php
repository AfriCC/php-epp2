<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Report\Contact as ReportContact;

$frame = new ReportContact(new NASKObjectSpec());
$frame->setContactId('k13');
$frame->setOffset(0);
$frame->setLimit(50);
echo $frame;
