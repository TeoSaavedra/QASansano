app.controller("editorCtrl", function ($scope,$uibModal,$log,$http) {
	console.log("editorCtrl Cargado");

	$scope.open = function () {
	    var modalInstance = $uibModal.open({
			animation: true,
			templateUrl: 'myModalContent.html',
			controller: 'ModalInstanceCtrl'	
    	});

    	modalInstance.result.then(function (tag) {
			$log.info(tag);
			angular.element('#taginput').tagsinput('add',tag);
    	}, function () {
      		$log.info('Modal dismissed at: ' + new Date());
    	});
	};
});

app.controller('ModalInstanceCtrl', function ($scope, $uibModalInstance,$http,$log) {

	$scope.ok = function () {
		$http({
			method: 'GET',
			url: '/tags/test',
			params: $scope.new_tag
		}).then(function (response){
			if(response.data.status){
				$http({
					method: 'POST',
					url: '/tags/store',
					data: $scope.new_tag
				}).then(function (response){
					if(response.data.status){
						$uibModalInstance.close(response.data.tag);
					}
					else{
						$log.error(response.error);
						$uibModalInstance.dismiss('cancel');
					}
				});
			}
		});
	};

	$scope.cancel = function () {
		$uibModalInstance.dismiss('cancel');
	};
});