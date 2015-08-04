app.controller('MenuController', function($scope, $cookieStore, $location, $window) {
	if(typeof($cookieStore.get('user')) != "undefined"){
		$scope.user = $cookieStore.get('user');
	}
	
	if(typeof($cookieStore.get('basket')) != "undefined"){
		$scope.basket = $cookieStore.get('basket');
	}

	$scope.logout = function(){
		$cookieStore.remove("user");
		$location.path("/");
		$window.location.reload();
	};
});
