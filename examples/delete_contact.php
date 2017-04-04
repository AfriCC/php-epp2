<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Delete\Contact as DeleteContact;

$frame = new DeleteContact();
$frame->setId('C001');
echo $frame;
