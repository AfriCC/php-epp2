<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Extension\COZA\Info\CozaContact as CozaContactInfoExtension;
use AfriCC\EPP\Extension\COZA\Update\CozaContact as CozaContactUpdateExtension;

$frame = new CozaContactInfoExtension();
$frame->setId('MyContact');
$frame->setAuthInfo('password');
$frame->requestBalance();
echo $frame;

echo PHP_EOL;

$frame = new CozaContactInfoExtension();
$frame->setId('MyContact');
$frame->setAuthInfo('password');
$frame->requestDomainListing();
echo $frame;

echo PHP_EOL;

$frame = new CozaContactUpdateExtension();
$frame->setId('MyContact');
$frame->cancelPendingAction();
echo $frame;
