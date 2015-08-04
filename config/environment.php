<?php

use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
/*
	ENVIRONMENT
	1 = dev
	2 = testing
	3 = production
*/
define("ENVIRONMENT", "1");

switch (ENVIRONMENT) {
    default:
        require 'development.php';
        break;
    case 2:
        require 'testing.php';
        break;
    case 3:
        require 'production.php';
        break;
}

$capsule->setAsGlobal();

$capsule->bootEloquent();

// set timezone for timestamps etc
date_default_timezone_set('UTC');


