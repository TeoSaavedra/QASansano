app.controller("questionShowCtrl", function ($scope,$log,$http,$location,$uibModal,$rootScope) {
	$log.info("questionShowCtrl Cargado");

	$scope.recommend = {
		id: 0,
		difficulty: 1,
		tags: []
	};

	$http.get($location.absUrl()+'/answers').then(function (response){
		$scope.answers = response.data;
	});

	$http.get($location.absUrl()+'/difficulty').then(function (response){
		$scope.difficulty = response.data.difficulty;
		$scope.recommend.difficulty = response.data.difficulty;
		$rootScope.$emit('recommendEvent',$scope.recommend);
	});

	$scope.ok = function (){
		$http({
			method: 'POST',
			url: $location.absUrl()+'/answers',
			data: {
				answer: $scope.myanswer
			}
		}).then(function (response){
			$scope.myanswer = "";
			if(response.data.status){
				$http.get($location.absUrl()+'/answers').then(function (response){
					$scope.answers = response.data;
				});
			}
		});
	};

	$scope.vote = function (answer,vote){
		$http({
			method: 'POST',
			url: '/answers/' + answer + '/vote',
			data: {vote: vote}
		}).then(function (response){
			if(response.data.status){
				$http.get($location.absUrl()+'/answers').then(function (response){
					$scope.answers = response.data;
				});
			}
		});
	};

	$scope.correct = function (answer){
		$http({
			method: 'POST',
			url: '/answers/' + answer + '/correct'
		}).then(function (response){
			if(response.data.status){
				$http.get($location.absUrl()+'/answers').then(function (response){
					$scope.answers = response.data;
				});
			}
		});
	};

	$scope.open = function(){
		var modalInstance = $uibModal.open({
			animation: true,
			templateUrl: 'myModalContent.html',
			controller: 'ModalInstanceCtrl',
			size: 'sm',
    	});

		modalInstance.result.then(function (difficulty) {
			$log.info(difficulty);
			$scope.difficulty = difficulty;
    	}, function () {
      		$log.info('Modal dismissed at: ' + new Date());
    	});
	};

});

app.controller('ModalInstanceCtrl', function ($scope,$uibModalInstance,$location,$http,$log) {
	
	$scope.ok = function () {
		$http({
			method: 'POST',
			url: $location.absUrl()+'/difficulty',
			data: {
				difficulty: $scope.difficulty
			}
		}).then(function (response){
			if(response.data.status){
				$uibModalInstance.close($scope.difficulty);
			}
			else
				$log.error(response.error);
		});
	};

	$scope.cancel = function () {
		$uibModalInstance.dismiss('cancel');
	};
});