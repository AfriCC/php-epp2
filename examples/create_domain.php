<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Create\Domain as CreateDomain;

$frame = new CreateDomain;
$frame->setDomain('google.co.uk');
$frame->setPeriod('1y');
//$frame->addHostObj('ns1.googledns.com');
//$frame->addHostObj('ns2.googledns.com');
$frame->addHostAttr('ns1.google.co.uk', [
	'8.8.8.8',
    '2a00:1450:4009:809::100e',
]);
$frame->addHostAttr('ns2.google.com');
$frame->setRegistrant('C001');
$frame->setAdminContact('C002');
$frame->setTechContact('C003');
$frame->setAuthInfo();
echo $frame;
