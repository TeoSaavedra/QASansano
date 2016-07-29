app.controller("questionHomeCtrl", function ($scope,$log,$http,$location,$timeout) {
	$log.info("questionHomeCtrl Cargado");

	$http.get('/questions').then(function (response){
		$scope.questions = response.data;
	});
	
	$scope.isVisible = false;

	$scope.slider = {
		options: {
			floor: 1,
			ceil: 5,
			showTicksValues: true
		}
	};

	$scope.filters = {
		career: "0",
		tags : [],
		difficulty: {
			min: 1,
			max: 5
		}
	};

	$scope.$watch('filters.tags',function(){$log.debug($scope.filters.tags);});

	$scope.switch = function(){
		$scope.isVisible = ! $scope.isVisible;
	};

	$scope.tagAdd = function(tag){
		$timeout(function(){
			angular.element('#taginput').tagsinput('add', {id: tag.id, tag: tag.tag, career_id: tag.career_id});
		});
	}
	$scope.safeApply = function(fn) {
		var phase = this.$root.$$phase;
		if(phase == '$apply' || phase == '$digest') {
			if(fn && (typeof(fn) === 'function')) {
		  		fn();
			}
		} else {
			this.$apply(fn);
		}
	};

	$scope.search = function(row){
		difficulty = row.difficulty >= $scope.filters.difficulty.min && row.difficulty <= $scope.filters.difficulty.max;
		
		if($scope.filters.tags.length){
			tags = false;
			angular.forEach(row.tags, function(value,key){
				// $log.debug($scope.filters.tags);
				if(!tags){
					if($scope.filters.tags.indexOf(String(value.id)) > -1)
						tags = true;
				}
			});
		}else{
			tags = true;
		}

		if($scope.filters.career == 0){
			career = true;
		}else{
			career = false;
			angular.forEach(row.tags, function(value,key){
				// $log.debug($scope.filters.tags);
				if(!career){
					if(value.career_id  == $scope.filters.career || value.career_id === null)
						career = true;
				}
			});
		}
		return difficulty && tags && career;
	}
});

app.directive("bnSlideShow",function ($log) {
	function link( $scope, element, attributes ) {
		var expression = attributes.bnSlideShow;
		var duration = ( attributes.slideShowDuration || "fast" );
		if ( ! $scope.$eval( expression ) ) {
			element.hide();
		}
		$scope.$watch(
			expression,
			function( newValue, oldValue ) {
				if ( newValue === oldValue ) {
					return;
				}
				if ( newValue ) {
					element.stop( true, true ).slideDown( duration );
					$scope.$broadcast('rzSliderForceRender');
					// $log.debug($scope.filters);
				} else {
					element.stop( true, true ).slideUp( duration );
					$scope.$broadcast('rzSliderForceRender');
					// $log.debug($scope.filters);
				}
			}
		);
	}

	return({
		link: link,
		restrict: "A"
	});
});