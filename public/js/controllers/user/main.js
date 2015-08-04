app.controller('UserController', function($scope, $http, $cookieStore, $modal, $window) {
	if(typeof($cookieStore.get('user'))== "undefined"){
		//Not loged
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
					modal = modalCreate($modal,"danger", "Error", "Email already in use.");
				}
			}).error(function(data, status, headers, config) {
				modal = modalCreate($modal,"danger", "Error", "Not connected with server.");
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
					modal = modalCreate($modal,"danger", "Error", "Wrong credentials.");
				}
			}).error(function(data, status, headers, config) {
				modal = modalCreate($modal,"danger", "Error", "No connected with server.");
			});
		};
	}else{
		//Loged
		$scope.user = $cookieStore.get('user');	
	}
});


