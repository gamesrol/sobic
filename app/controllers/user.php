<?php

$app->group('/user', function () use ($app) {

	$app->get('/', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["user"] = [];
		$results["success"]= "false";

		if (validatedKey($data["user"]["id"], $data["user"]["key"])) {
			$user = user::where('id', '=', $data["user"]["id"])->first();
			$results["user"] = $user;

			$results["success"]= "true";
		} else {
			$results["success"]= "false";
			$results["error"]= "No auth";
		}
		echo json_encode($results);
	});

	$app->post('/new', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";

		if(!User::where('email', '=', $data["user"]["email"])->exists()){
			$user = new User();
			$user->email = $data["user"]["email"];
			$user->password = hash('sha512',$data["user"]["password"]);
			$user->save();
			$encriptedKey = hash('sha512', $user->id.$user->email.$user->created_at);
			$results["id"] = $user->id;
			$results["email"] = $user->email;
			$results["isAdmin"] = $user->isAdmin;
			$results["key"] = $encriptedKey;
			$results["success"]= "true";
		}
		echo json_encode($results);
	});

	$app->post('/login', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";
		
		$veri = User::where('email', '=', $data['user']['email'])->where('password', '=', hash('sha512', $data['user']['password']))->exists();

		if($veri){
			$results["id"] = $veri->id;
			$results["email"] = $veri->email;
			$results["isAdmin"] = $veri->isAdmin;
			$results["key"] = hash('sha512', $user->id.$user->email.$user->created_at);
			$results["success"]= "true";
		}
	
		echo json_encode($results);
	});

	$app->get('/list', function () use ($app) {
		$users = User::all();
		$results["users"] = $users;
		echo json_encode($results);
	});
});
