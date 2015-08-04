<?php

/**
 * Configure of production
 */

$capsule->addConnection(array(
	'driver'    => 'mysql',
	'host'      => getenv('IP'),
	'port'      => 3306,
	'database'  => 'c9',
	'username'  => getenv('C9_USER'),
	'password'  => '',
	'prefix'    => '',
	'charset'   => "utf8",
	'collation' => "utf8_unicode_ci"
));
