<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\ObjectSpec;
use AfriCC\EPP\Extension\NASK\Update\Future as UpdateFuture;

ObjectSpec::overwriteParent();

$frame = new UpdateFuture();
$frame->setFuture('example7.pl');
$frame->changeRegistrant('mak21');
$frame->changeAuthInfo('2fooBAR');
echo $frame;
