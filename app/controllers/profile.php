<?php

/**
 * Profile Controller
 */

$app->group('/profiles', function () use ($app) {
	$app->post('/', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);
		$results = [];
		if (validatedKey($data['user'])) {
			$results['profile'] = Profile::where('user_id', '=', $data['user']['id'])->first();
			$results["success"]= "true";
		}else{
			$results["success"]= "false";
		}

		echo json_encode($results);
	});

	$app->get('/show/:id', function ($id) use ($app) {
		$results = [];
		$results["profile"] = Profile::find($id);
		$results["success"]= "true";

		echo json_encode($results);
	});

	$app->post('/form', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";
		if (validatedKey($data['user'])) {
			if(isset($data['profile']['id'])){
				Profile::find($data['profile']['id'])->update($data['profile']);
				$results["value"]= "Update";
			}else{
				Profile::create($data['profile']);
				$results["value"]= "New";
			}

			$results["success"]= "true";
			
		} else {
			$results["success"]= "false";
			$results["error"]= "No auth";
		}

		echo json_encode($results);
	});

	$app->post('/delete', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);
		$results = [];
		$results["success"]= "false";

		if (validatedKey($data['user'])) {
			$personal = Profile::find($data['personal']['id']);
			$personal->delete();
			$results["profiles"] = Profile::all();
			$results["success"]= "true";
			$results["value"]= "delete";
		} else {
			$results["success"]= "false";
			$results["error"]= "No auth";
		}

		echo json_encode($results);
	});
});
