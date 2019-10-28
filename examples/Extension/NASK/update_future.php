<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Update\Future as UpdateFuture;

$frame = new UpdateFuture(new NASKObjectSpec());
$frame->setFuture('example7.pl');
$frame->changeRegistrant('mak21');
$frame->changeAuthInfo('2fooBAR');
echo $frame;
