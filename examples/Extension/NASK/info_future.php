<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\Info\Future as InfoFuture;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;

$frame = new InfoFuture(new NASKObjectSpec());
$frame->setFuture('example.pl');
$frame->setAuthInfo('2fooBAR');
echo $frame;
