<?php

require __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('UTC');

if (!empty(getenv('TEST_DOMAIN'))) {
    define('TEST_DOMAIN', getenv('TEST_DOMAIN'));
} else {
    define('TEST_DOMAIN', 'epptest.org');
}
