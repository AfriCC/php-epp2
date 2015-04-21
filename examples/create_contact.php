<?php

// debug
error_reporting(E_ALL);
ini_set('display_errors', true);

chdir(__DIR__);

require '../src/AfriCC/autoload.php';

use AfriCC\EPP\Frame\Command\Create\Contact as CreateContact;

$frame = new CreateContact;
$frame->setId('CONTACT1');
$frame->setName('Günter Grodotzki');
$frame->setName('Jun Grodotzki');
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
$frame->addDisclose('voice');
$frame->addDisclose('email');
echo $frame;
var_dump($auth);
