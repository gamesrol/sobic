app.controller('RecoveryController', function($scope, $http, $uibModal, $routeParams, $filter) {
		var key_token = $routeParams.key_token;

		$scope.changePass = function(pass){
			$http({
				method: 'POST',
				url: serverURL+"/user/recovery/"+key_token,
				data: {
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
});
