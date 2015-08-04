<?php
/** Carga las dependencias**/
require __DIR__.'/../vendor/autoload.php';

/** Compilamos el less a css, en el caso de que existan cambios y no estemos en producion **/
if (ENVIRONMENT != 3){
	autoCompileLess('css/less/main.less', 'css/main.css');
}

/** Creamos la api res y cargamos las llamadas **/
$app = new \Slim\Slim();

/** Requerimos las rutas **/
require '../app/main.php';

$app->run();
