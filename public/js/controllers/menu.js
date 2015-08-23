app.controller('MenuController', function($scope, $cookieStore, $location, $window) {
	if(typeof($cookieStore.get('user')) != "undefined"){
		$scope.user = $cookieStore.get('user');
	}

	$scope.logout = function(){
		$cookieStore.remove("user");
		$location.path("/");
		$window.location.reload();
	};
});
