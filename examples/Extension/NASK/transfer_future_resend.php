<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;
use AfriCC\EPP\Extension\NASK\Transfer\Future as TransferFuture;

$frame = new TransferFuture(new NASKObjectSpec());
$frame->setOperation('request');
$frame->setFuture('example.pl');
$frame->setAuthInfo('2fooBAR');
$frame->resendConfirmationRequest();
echo $frame;
