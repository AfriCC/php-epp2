<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\Delete\Future as DeleteFuture;
use AfriCC\EPP\Extension\NASK\ObjectSpec as NASKObjectSpec;

$frame = new DeleteFuture(new NASKObjectSpec());
$frame->setFuture('futuretest.pl');
echo $frame;
