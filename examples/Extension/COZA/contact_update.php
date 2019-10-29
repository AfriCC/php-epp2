<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../../../vendor/autoload.php';

use AfriCC\EPP\Extension\COZA\Update\CozaContact as CozaContactUpdateExtension;

$frame = new CozaContactUpdateExtension();
$frame->setId('MyContact');
$frame->cancelPendingAction();
echo $frame;
