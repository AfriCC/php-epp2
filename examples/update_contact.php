<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Update\Contact as ContactUpdate;

$frame = new ContactUpdate;
$frame->setId('C0054');
$frame->addCity('Voerde');
$frame->addAddStreet('Long St. 14');
$frame->addAddStreet('CBD');
$frame->changeAddStreet('Long St. 15');
$frame->changeCity('Cape Town');
$frame->removeAddStreet('Long St. 16');
$frame->removeCity('Durban');
echo $frame;
