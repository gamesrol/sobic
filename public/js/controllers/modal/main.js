app.controller('ModalController', function ($scope, $modalInstance,  modal) {
	
	//Modal config
	$scope.modal = modal;
	
	// Close modal function
	$scope.closeModal = function () {
		$modalInstance.dismiss('cancel');
	};

});
