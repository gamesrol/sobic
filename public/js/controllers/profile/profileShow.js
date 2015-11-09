app.controller('ProfileController', function($scope, $cookieStore, $http, $filter, $uibModal) {
	if(typeof($cookieStore.get('user')) != "undefined"){
		$scope.user = $cookieStore.get('user');

		$http({
			method: 'POST',
			url: serverURL+"/profiles/",
			data: {
				user: $scope.user
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
		}).success(function(data, status, headers, config) {
			if(data.success == "true"){
				$scope.profile = data.profile;
			}else{
				modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_unknow') );
			}
		}).error(function(data, status, headers, config) {
			modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
		});
	}
});
