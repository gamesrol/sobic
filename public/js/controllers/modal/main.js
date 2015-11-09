app.controller('ModalController', function ($scope, $uibModalInstance,  modal) {
	
	//Modal config
	$scope.modal = modal;
	
	// Close modal function
	$scope.closeModal = function () {
		$uibModalInstance.dismiss('cancel');
	};

});
