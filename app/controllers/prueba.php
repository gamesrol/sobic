<?php

/**
 * Prueba Controller
 */

$app->group('/pruebas', function () use ($app) {
	$app->get('/', function () use ($app) {
		$results = [];
		$results['pruebas'] = Prueba::all();

		$results["success"]= "true";

		echo json_encode($results);
	});

	$app->get('/show/:id', function ($id) use ($app) {
		$results = [];
		$results["prueba"] = Prueba::find($id);
		$results["success"]= "true";

		echo json_encode($results);
	});

	$app->post('/form', function () use ($app) {
		$data = json_decode($app->request->getBody(), true);

		$results = [];
		$results["success"]= "false";
		if (validatedKey($data['user'])) {
			if(isset($data['prueba']['id'])){
				Prueba::find($data['prueba']['id'])->update($data['prueba']);
			}else{
				Prueba::create($data['prueba']);
			}

			$results["success"]= "true";
			$results["value"]= "New";
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
			$prueba = Prueba::find($data['prueba']['id']);
			$prueba->delete();
			$results["pruebas"] = Prueba::all();
			$results["success"]= "true";
			$results["value"]= "delete";
		} else {
			$results["success"]= "false";
			$results["error"]= "No auth";
		}

		echo json_encode($results);
	});
});
