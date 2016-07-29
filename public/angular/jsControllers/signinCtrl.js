app.controller("SignInCtrl", function($scope,$http,$location) {
	console.log("SignInCtrl cargado");

	$scope.fname = "";
	$scope.lname = "";
	$scope.email = "";
	$scope.passwd = "";
	$scope.passwd2 = "";
	$scope.incomplete = true;

	$scope.$watch('fname',function() {$scope.test();});
	$scope.$watch('lname',function() {$scope.test();});
	$scope.$watch('email',function() {$scope.test();});
	$scope.$watch('passwd',function() {$scope.test();});
	$scope.$watch('passwd2',function() {$scope.test();});

	$scope.test = function() {

		if(	$scope.fname.length  && $scope.lname.length  && 
			$scope.email		 && $scope.passwd.length && $scope.passwd2.length){
			if($scope.passwd == $scope.passwd2)
				$scope.incomplete = false;
			else 
				$scope.incomplete = true;
		}
		else 
			$scope.incomplete = true;

	};
	
});