app.controller('ListUsersController', function($scope, $http, $cookieStore) {
	if(typeof($cookieStore.get('user')) != "undefined"){
		$scope.user = $cookieStore.get('user');
	}
	$http({
		method: 'GET',
		url: serverURL+"/user/list",
		data: {
				user: $scope.user
		},
		headers: {'Content-Type': 'application/x-www-form-urlencoded'},
	}).success(function(data, status, headers, config) {
	if(data.success == "true"){
			$scope.list = data.users;
		}else{
			modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_unknow') );
		}
	}).error(function(data, status, headers, config) {
		modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
	});
});
