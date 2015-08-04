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
		$scope.list = data.users;
	}).error(function(data, status, headers, config) {
		console.log("error");
	});
});
