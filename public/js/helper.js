/* En esta sección se encuentra la función que controla los modals */
function modalCreate($uibModal, type, title, body ){
	var modalInstance = $uibModal.open({
      	templateUrl: 'partials/modal/main.html',
	  	controller: 'ModalController',
	  	size: 'md',
      	resolve: {
        	modal: function () {
          		return {type: type, title: title, body: body};
        	}
		}
    });
    return modalInstance;
}

function modalCreatelog($uibModal, logg ){
	var modalInstance = $uibModal.open({
      	templateUrl: 'partials/user/userMain.html',
	  	controller: 'UserController',
	  	size: 'md',
      	resolve: {
        	modal: function () {
          		return {logg: logg};
        	}
		}
    });
    return modalInstance;
}

$(function() {
    $('#navbar .nav a').on('click', function(){ 
        if($('#btn-info').css('display') !='none'){
            $("#btn-info").trigger( "click" );
        }
    });
});


app.directive("closedmenu", function () {
	return function(scope, element, attrs) {
		angular.element(element).bind("click", function() {
			if($('#btn-info').attr('aria-expanded') !='false'){
				$("#btn-info").trigger( "click" );
			}
			if($('#btn-app').attr('aria-expanded') !='false'){
				$("#btn-app").trigger( "click" );
			}
			return true;
		});
	};
});
