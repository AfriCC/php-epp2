<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\Info\Future as InfoFuture;
use AfriCC\EPP\Extension\NASK\ObjectSpec;

ObjectSpec::overwriteParent();

$frame = new InfoFuture();
$frame->setFuture('example.pl');
$frame->setAuthInfo('2fooBAR');
echo $frame;
