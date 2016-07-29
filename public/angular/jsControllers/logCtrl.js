app.controller("logCtrl", function($scope,$http) {
	console.log("logCtrl cargado");
	
	$scope.email = "";
	$scope.passwd = "";
	$scope.incomplete = true;

	$scope.$watch('email',function() {$scope.test();});
	$scope.$watch('passwd',function() {$scope.test();});

	$scope.test = function () {
		if(	$scope.email && $scope.passwd.length )
			$scope.incomplete = false;
		else 
			$scope.incomplete = true;
	};

	$scope.ok = function ($form) {
		$http({
			method: 'POST',
			url: 'login/test',
			data: {
				email: $scope.email,
				password: $scope.passwd
			}
		}).then(function (response) {
			if(response.success){
				if($form.$valid){
					$form.commit();
				}
			}
		});
	};


});

app.directive("ngFormCommit", [function(){
    return {
        require:"form",
        link: function($scope, $el, $attr, $form) {
            $form.commit = function() {
                $el[0].submit();
            };
        }
    };
}])
