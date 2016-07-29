app.controller("recommendationCtrl", function ($scope,$log,$http,$location,$rootScope) {
	$log.info("recommendationCtrl Cargado");

	$rootScope.$on('recommendEvent',function (event,args){
		$scope.filters = args;
		// $log.debug($scope.filters);
		$http.get('/questions').then(function (response){
			$scope.questions = response.data;
		});
	});

	$scope.all = function(row){
		difficulty = row.difficulty == $scope.filters.difficulty

		self = row.id != $scope.filters.id;

		tags = false;

		angular.forEach(row.tags, function(value,key){
			if(!tags){
				if($scope.filters.tags.indexOf(parseInt(value.id)) > -1)
					tags = true;
			}
		});

		return difficulty && tags && self;
	}

	$scope.by_tags = function(row){

		self = row.id != $scope.filters.id;

		tags = false;

		angular.forEach(row.tags, function(value,key){
			if(!tags){
				if($scope.filters.tags.indexOf(parseInt(value.id)) > -1)
					tags = true;
			}
		});

		return tags && self;
	}

	$scope.by_diff = function(row){
		difficulty = row.difficulty == $scope.filters.difficulty

		self = row.id != $scope.filters.id;

		return difficulty && self;
	}


});