app.controller('authCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, ngDialog) {
    //initially set those objects to null to avoid undefined error
	$scope.logincount=0;
	
    $scope.login = {};
    $scope.signup = {};
    $scope.doLogin = function (customer) {
        Data.post('login', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
				$scope.logincount =1;
                $location.path('dashboard');
            }
        });
    };
    $scope.signup = {email:'',password:'',name:'',phone:'',address:''};
    $scope.signUp = function (customer) {
        Data.post('signUp', {
            customer: customer
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
				$scope.logincount =1;
                $location.path('dashboard');
            }
        });
    };
    $scope.logout = function () {
		//alert('came');
		$scope.logincount=0;
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }
	
	$rootScope.$on('logoutEvent', function(event) {
		//alert('came to logoutEvent');
		//alert($scope.logincount);
		if($scope.logincount==1)
        $scope.logout();
    });

    $scope.openPlain = function () {

    $rootScope.theme = 'ngdialog-theme-plain';

    ngDialog.open({

    //template: 'firstDialogId',
    templateUrl : 'test.html',
    controller: 'helpCtrl',

    className: 'ngdialog-theme-plain'

    });

    };

 

	
});