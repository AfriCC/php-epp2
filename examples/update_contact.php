<?php

// TODO: This example generates code not compliant with RFC 5733
// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Update\Contact as UpdateContact;

$frame = new UpdateContact();
$frame->setId('C0054');
$frame->changeVoice('+12.345678', '123');
$frame->addCity('Voerde');
$frame->addAddStreet('Long St. 14');
$frame->addAddStreet('CBD');
$frame->changeAddStreet('Long St. 15');
$frame->changeCity('Cape Town');
$frame->removeAddStreet('Long St. 16');
$frame->removeCity('Durban');
$frame->addStatus('clientUpdateProhibited');
$frame->removeStatus('clientDeleteProhibited');
echo $frame;
