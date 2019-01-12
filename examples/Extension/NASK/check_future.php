<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require './_autoload.php';
use AfriCC\EPP\Extension\NASK\Check\Future as CheckFuture;
use AfriCC\EPP\Extension\NASK\ObjectSpec;

ObjectSpec::overwriteParent();

$frame = new CheckFuture();
$frame->addFuture('ala.pl');
$frame->addFuture('ela.com.pl');
$frame->addFuture('ola.org');

echo $frame;
