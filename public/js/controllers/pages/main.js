app.controller('PageMainController', function($scope, $http, $cookieStore) {
    $scope.cookies = 1;
    
    $scope.aceptCookies = function(){
        $scope.cookies = 0;
        $cookieStore.put('cookies', 1);
    }

    if($cookieStore.get('cookies')){
        $scope.cookies = 0;
    } else {
        $scope.cookies = 1;
    }
    
});


