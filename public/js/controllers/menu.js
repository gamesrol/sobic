app.controller('MenuController', function($scope, $cookieStore, $location, $window, $uibModal, $translate) {
	$translate.use('en');
	if(typeof($cookieStore.get('user')) != "undefined"){
		$scope.user = $cookieStore.get('user');

		$scope.logout = function(){
			$cookieStore.remove("user");
			$location.path("/");
			$window.location.reload();
		};
	}else{
		$scope.logg = function(log){
			modalCreatelog($uibModal, log);
		};
	}
	
	$scope.changeLanguage = function (langKey) {
		$translate.use(langKey);
	};
});
