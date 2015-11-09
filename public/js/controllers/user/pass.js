app.controller('ChangePassController', function($scope, $http, $uibModal, $filter, $cookieStore) {
	if(typeof($cookieStore.get('user')) != "undefined"){
		$scope.user = $cookieStore.get('user');
		$scope.changePass = function(pass){
			$http({
				method: 'POST',
				url: serverURL+"/user/pass",
				data: {
						user: $scope.user,
						pass: $scope.pass
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {
				if(data.success == "true"){
						modal = modalCreate($uibModal,"success", $filter('translate')('success') ,  $filter('translate')('success_msg') );
				}else{
					modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
				}
			}).error(function(data, status, headers, config) {
				modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
			});
		}
	}
});
