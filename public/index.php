<?php
/** Carga las dependencias**/
require __DIR__.'/../vendor/autoload.php';

/** Creamos la api res y cargamos las llamadas **/
$app = new \Slim\App;

/** Requerimos las rutas **/
require '../app/main.php';

$app->run();
