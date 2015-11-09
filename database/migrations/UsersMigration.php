<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * User Migrate
 */

class UsersMigration {
	function run()
	{
		Capsule::schema()->dropIfExists('users');

		Capsule::schema()->create('users', function($table) {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password');
			$table->boolean('isAdmin');
			$table->string('img');
			$table->string('social');
			$table->timestamps();
		});
	}
}
