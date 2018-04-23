app.controller('logoutCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data,$templateCache, $window,$timeout,Utils) {
    
    function logout()
	{
		//alert('came');
		$templateCache.removeAll();

		
		$scope.logincount=0;
        Data.get('logout').then(function (results) {
            if(!Utils.isUndefinedOrNull(results) && !Utils.isUndefinedOrNull(results.message))
            Data.toast(results);
            //$location.path('login');
            //window.location.href="#/login";
            //$window.location.reload()
            $timeout( function(){  $window.location.reload(); }, 2000);
            //$window.location.href ="#/login";
        });
        //window.location.href="#/login";
    }
	
	logout();
	
});