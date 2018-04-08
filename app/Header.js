app.directive('headerHtml', function($rootScope,$location) { 
  return { 
    restrict: 'E', 
    //scope: { 
    //  info: '=' 
   // }, 
    templateUrl: 'partials/Common/Header.html' ,
	 controller: ["$scope", "$rootScope", function($scope, $rootScope) {
                
                
                $scope.logoutuserifany = function() {
					//alert('fromm header');
                    $rootScope.$emit('logoutEvent',{});
                }
				$scope.myprofile = function() {
					$location.path("/profile");
                }
            }]
  }; 
});