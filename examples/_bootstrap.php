<?php

if (!file_exists(dirname(__FILE__).'/../credentials.php')) {
    throw new Exception('credentials.php file required in root');
}

include_once dirname(__FILE__).'/../vendor/autoload.php';
require_once dirname(__FILE__).'/../credentials.php';
