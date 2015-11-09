<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Pruebas Migrate
 */

class PruebasMigration {
	function run()
	{
		Capsule::schema()->dropIfExists('pruebas');

		Capsule::schema()->create('pruebas', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->date('hola');
			$table->timestamps();
		});
	}
}