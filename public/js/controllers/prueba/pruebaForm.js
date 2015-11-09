app.controller('PruebaFormController', function($scope, $cookieStore, $http, $location, $routeParams, $uibModal) {
	if( typeof($cookieStore.get('user')) != "undefined" ){
		$scope.user = $cookieStore.get('user');	
		if($routeParams.id){
			$http({
				method: 'GET',
				url: serverURL+"/pruebas/show/"+$routeParams.id,
				data: {
					user: $scope.user
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {

				if(data.success == "true"){
					$scope.prueba = data.prueba;
				}else{
					modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_unknow") );
				}
			}).error(function(data, status, headers, config) {
				modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_connection") );
			});
		}

		$scope.createPrueba = function (prueba) {
			$http({
				method: 'POST',
				url: serverURL+"/pruebas/form",
				data: {
					prueba: prueba,
					user: $scope.user
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {
				if(data.success == "true"){
					$location.path( "/pruebas" );
				}else{
					modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_unknow") );
				}
			}).error(function(data, status, headers, config) {
				modal = modalCreate($uibModal,"danger", $filter("translate")("error") ,  $filter("translate")("error_connection") );
			});
		};
		$scope.status = {
			opened: false
		};
		$scope.open = function($event) {
			$scope.status.opened = true;
		};
	}
});
