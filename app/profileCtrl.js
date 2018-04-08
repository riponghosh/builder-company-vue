

var profileCtrl = app.controller('profileCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $filter) {
    //initially set those objects to null to avoid undefined error
	
    $scope.logoutUser = function () {
		//alert('fromm profile ctrl');
        $rootScope.$emit('logoutEvent',{});
    };
	$scope.user = null;
	$scope.doUpdateProfile = function (user) {
        Data.post('updateprofile', {
            user: user
        }).then(function (results) {
            //Data.toast(results);
            if (results.status == "success") {
				Data.toast(results);
            }
        });
    };
	
	function LoadProfile()
	{
			Data.get('GetLoggedUserInfo').then(function (results) {
				//alert(results.user);
				$scope.user = results.user;
            });
				
	}
	
	LoadProfile();
	
});

