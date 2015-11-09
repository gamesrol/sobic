app.controller('PruebaController', function($scope, $cookieStore, $http, $filter, $uibModal) {
	if(typeof($cookieStore.get('user')) != "undefined"){
		$scope.user = $cookieStore.get('user');
	}

	$http({
		method: 'GET',
		url: serverURL+"/pruebas/",
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
		if(data.success == "true"){
			$scope.list = data.pruebas;
		}else{
			modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_unknow") );
		}
	}).error(function(data, status, headers, config) {
		modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_connection") );
	});

	$scope.removePrueba = function(prueba){
		var basket = $cookieStore.get('basket');
		$http({
			method: 'POST',
			url: serverURL+"/pruebas/delete",
			data: {
				prueba: prueba,
				user: $scope.user
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if(data.success == "true"){
				var index = $scope.list.indexOf(prueba)
				$scope.list.splice(index, 1);
			}else{
				modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_unknow") );
			}
		}).error(function(data, status, headers, config) {
			modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_connection") );
		});
	};
});
