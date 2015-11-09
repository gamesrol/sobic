app.controller('UserController', function($scope, $http, $cookieStore, $uibModal, $uibModalInstance, $window, $filter, modal) {
	$scope.logg = modal.logg;

	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};

	$scope.change = function(view){
		$scope.logg = view;
	}

	$scope.registerUser = function(register){
		$http({
			method: 'POST',
			url: serverURL+"/user/new",
			data: {
				user: register
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if(data.success == "true"){
				$cookieStore.put('user',data);
				$window.location.reload();
			}else{
				modal = modalCreate($uibModal,"danger", $filter('translate')('error') , $filter('translate')('error_email') );
			}
		}).error(function(data, status, headers, config) {
			modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,   $filter('translate')('error_connection') );
		});
	};

	$scope.loginUser = function(login){
		$http({
			method: 'POST',
			url: serverURL+"/user/login",
			data: {
					user: login
				},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if(data.success == "true"){
				$cookieStore.put('user',data);
				$window.location.reload();
			}else{
				modal = modalCreate($uibModal,"danger", $filter('translate')('error'), $filter('translate')('error_login') );
			}
		}).error(function(data, status, headers, config) {
			modal = modalCreate($uibModal,"danger", $filter('translate')('error'),  $filter('translate')('error_connection') );
		});
	};

	$scope.recovery = function(email){
		$http({
			method: 'POST',
			url: serverURL+"/user/recover",
			data: {
					email: email
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if(data.success == "true"){
					modal = modalCreate($uibModal,"success", $filter('translate')('success') ,  $filter('translate')('success_rec') );
			}else{
				modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
			}
		}).error(function(data, status, headers, config) {
			modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
		});
	}
})