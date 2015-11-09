<?php

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * UsersReco Migrate
 */

class UsersRecoMigration {
	function run()
	{
		Capsule::schema()->dropIfExists('usersReco');

		Capsule::schema()->create('usersReco', function($table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->string('email');
			$table->string('key_token');
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
		});
	}
}