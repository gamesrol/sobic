app.controller('ProfileFormController', function($scope, $cookieStore, $http, $location, $uibModal, $filter, Upload) {
	if( typeof($cookieStore.get('user')) != "undefined" ){
		$scope.user = $cookieStore.get('user');	
		$scope.progressPercentage = 0;
		$scope.today = new Date();

		$http({
			method: 'POST',
			url: serverURL+"/profiles/",
			data: {
				user: $scope.user
			},
			headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {
				if(data.success == "true"){
					if(data.profile){
						$scope.profile = data.profile;
					}else{
						$scope.profile = {};
						$scope.profile.user_id = $scope.user.id;
					}
				}else{
					modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_unknow') );
				}
			}).error(function(data, status, headers, config) {
				modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
			});

		$scope.createProfile = function (profile) {
			$http({
				method: 'POST',
				url: serverURL+"/profiles/form",
				data: {
					profile: profile,
					user: $scope.user
				},
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
			}).success(function(data, status, headers, config) {
				if(data.success == "true"){
					$location.path( "/profile" );
				}else{
					modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_unknow') );
				}
			}).error(function(data, status, headers, config) {
				modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_connection') );
			});
		};
		
		// upload on file select or drop
		$scope.upload = function (file) {
			if (file && !file.$error) {
				Upload.upload({
					url: serverURL+"/user/photo",
					data: {'user': $scope.user},
					file: file
				}).progress(function (evt) {
					var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
					$scope.progressPercentage = progressPercentage;
				}).success(function (data, status, headers, config) {
					$scope.user.img = data.img;
					$cookieStore.put('user', $scope.user);
					$scope.progressPercentage = 0;
				}).error(function (data, status, headers, config) {
					modal = modalCreate($uibModal,"danger", $filter('translate')('error') ,  $filter('translate')('error_img') );
				})
			}
		};

		$scope.status = {
			opened: false
		};
		$scope.open = function($event) {
			$scope.status.opened = true;
		};
		
		$scope.dateOptions = {
			language: 'es',
			startView: 'year'
		}
	}
});
