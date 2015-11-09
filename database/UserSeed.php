<?php

class UserSeed {

	function run()
	{
		$user = new User;
		$user->email = "sobic@sobic.nextsun";
		$user->password = "d404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db";
		$user->isAdmin = true;
		$user->img = "dsadssd";
		$user->social = "dsadssd";
		$user->save();
	}
}
