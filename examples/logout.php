<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Logout;

$frame = new Logout;
echo $frame;
