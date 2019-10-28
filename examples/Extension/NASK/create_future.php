<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\Create\Future as CreateFuture;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;

$frame = new CreateFuture(new NASKObjectSpec());
$frame->setFuture('example.pl');
$frame->setPeriod('3y');
$frame->setRegistrant('jd1234');
$frame->setAuthInfo('2fooBAR');
echo $frame;
