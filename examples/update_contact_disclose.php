<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Update\Contact as UpdateContact;

$frame = new UpdateContact();
$frame->setId('C0054');
$frame->addCity('Voerde');
$frame->addAddStreet('Long St. 14');
$frame->addAddStreet('CBD');
$frame->changeAddStreet('Long St. 15');
$frame->changeCity('Cape Town');
$frame->removeAddStreet('Long St. 16');
$frame->removeCity('Durban');
$frame->changeAddDisclose('voice', 1);
$frame->changeAddDisclose('name[@type=\'int\']', 1);
echo $frame;
