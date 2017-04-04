<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../vendor/autoload.php';

use AfriCC\EPP\Frame\Command\Create\Contact as CreateContact;

$frame = new CreateContact();
$frame->skipInt();
$frame->setId('CONTACT1');
$frame->setName('Günter Grodotzki');
$frame->setOrganization('weheartwebsites UG');
$frame->addStreet('Rönskenstraße 23');
$frame->addStreet('Around the Corner');
$frame->setCity('Cape Town');
$frame->setProvince('WC');
$frame->setPostalCode('8001');
$frame->setCountryCode('ZA');
$frame->setVoice('+27.844784784');
$frame->setFax('+1.844784784');
$frame->setEmail('github@afri.cc');
$auth = $frame->setAuthInfo();
$frame->addDisclose('voice', 1);
$frame->addDisclose('email', 0);
echo $frame;
var_dump($auth);
