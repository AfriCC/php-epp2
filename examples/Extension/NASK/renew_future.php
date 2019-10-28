<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Renew\Future as RenewFuture;

$frame = new RenewFuture(new NASKObjectSpec());
$frame->setFuture('example.pl');
$frame->setCurrentExpirationDate('2010-10-30');
$frame->setPeriod('3y');
echo $frame;
