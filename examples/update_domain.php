<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Update\Domain as UpdateDomain;

$frame = new UpdateDomain();
$frame->setDomain('google.com');
$frame->addAdminContact('ADMIN-1');
$frame->addTechContact('TECH-2');
$frame->addHostObj('ns1.google.com');
$frame->addHostAttr('ns2.google.com', ['8.8.8.8', '2a00:1450:4009:809::100e']);
$frame->addStatus('clientHold', 'Payment overdue.');
$frame->removeHostAttr('ns3.google.com');
$pw = $frame->changeAuthInfo();
echo $frame;
