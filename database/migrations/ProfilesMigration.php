<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Personals Migrate
 */

class ProfilesMigration {
	function run()
	{
		Capsule::schema()->dropIfExists('profiles');

		Capsule::schema()->create('profiles', function($table) {
			$table->increments('id');
			$table->integer('user_id')->unique()->unsigned();
			$table->string('title');
			$table->string('name');
			$table->string('surname');
			$table->date('dateBirth');
			$table->integer('phoneNumber');
			$table->string('address');
			$table->string('postalCode');
			$table->string('city');
			$table->string('country');
			$table->text('summary');
			$table->string('url');
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
	}
}