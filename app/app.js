var app = angular.module('myApp', ['ui.bootstrap','angularUtils.directives.dirPagination','ngResource','ngRoute', 'ngAnimate', 'toaster','ngTable','angularjs-datetime-picker','ngDialog','ui-notification','pageslide-directive']);

app.config(['$routeProvider',
  function ($routeProvider) {
        $routeProvider.
        when('/login', {
            title: 'Login',
            templateUrl: 'partials/login.html',
            controller: 'authCtrl'
        })
            .when('/logout', {
                title: 'Logout',
                templateUrl: 'partials/logout.html',
                controller: 'logoutCtrl'
            })
            .when('/signup', {
                title: 'Signup',
                templateUrl: 'partials/signup.html',
                controller: 'authCtrl'
            })
            .when('/dashboard', {
                title: 'Dashboard',
                templateUrl: 'partials/dashboard.html',
                //controller: 'authCtrl'
				controller: 'dashboardCtrl'
            })
			.when('/profile', {
                title: 'profile',
                templateUrl: 'partials/profile.html',
                //controller: 'authCtrl'
				controller: 'profileCtrl'
            })
			.when('/usermgmt', {
                title: 'User Management',
                templateUrl: 'partials/usermgmt.html',
                //controller: 'authCtrl'
				controller: 'usermgmtCtrl'
            })
    			.when('/usermgmt/view/:id',
    			{
    				title: 'User Management',
                    templateUrl: 'partials/usermgmtEdit.html',
                    //controller: 'authCtrl'
    				controller: 'usermgmtCtrl'
    			})
            .when('/message',
            {
                title: 'Messages',
                templateUrl: 'partials/message.html',
                //controller: 'authCtrl'
                controller: 'messageCtrl'
            })
            .when('/message/add',
            {
                title: 'Messages',
                templateUrl: 'partials/messageAdd.html',
                //controller: 'authCtrl'
                controller: 'messageCtrl'
            })
            .when('/message/:id',
            {
                title: 'User Management',
                templateUrl: 'partials/messageView.html',
                //controller: 'authCtrl'
                controller: 'messageCtrl'
            })
            
            .when('/', {
                title: 'Login',
                templateUrl: 'partials/login.html',
                controller: 'authCtrl',
                role: '0'
            })
            .otherwise({
                redirectTo: '/login'
            });
  }])
    .run(function ($rootScope, $location, Data,$http) {
        $rootScope.$on("$routeChangeStart", function (event, next, current) {
            $rootScope.authenticated = false;
            
            Data.get('session').then(function (results) {
				//alert(results);
                if (results.uid) {
                    $rootScope.authenticated = true;
                    $rootScope.uid = results.uid;
                    $rootScope.name = results.name;
                    $rootScope.email = results.email;
					         $rootScope.isadmin = (results.isadmin==1);
					         $rootScope.userWidgets = results.userWidgets;
					//$rootScope.userHotels = results.userHotels;
					//alert($rootScope.userWidgets);
                } else {
                    var nextUrl = next.$$route.originalPath;
                    if (nextUrl == '/signup' || nextUrl == '/login') {

                    } else {
                        $location.path("/login");
                    }
                }
            });
        });
    });

app.filter('nl2br', function($sce){
  return function(msg,is_xhtml) { 
      var is_xhtml = is_xhtml || true;
      var breakTag = (is_xhtml) ? '<br />' : '<br>';
      var msg = (msg + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1'+ breakTag +'$2');
      return $sce.trustAsHtml(msg);
  }
});


app.run(function($rootScope, $timeout, $document) {    
    console.log('starting run');

    // Timeout timer value
    // 30 minutes
    var TimeOutTimerValue = 5000*12*60;

    // Start a timeout
    var TimeOut_Thread = null;
    //if($rootScope.authenticated)
     TimeOut_Thread = $timeout(function(){ LogoutByTimer() } , TimeOutTimerValue);

    var bodyElement = angular.element($document);
    
    angular.forEach(['keydown', 'keyup', 'click', 'mousemove', 'DOMMouseScroll', 'mousewheel', 'mousedown', 'touchstart', 'touchmove', 'scroll', 'focus'], 
    function(EventName) {
        
         bodyElement.bind(EventName, function (e) { TimeOut_Resetter(e) });  
    });

    function LogoutByTimer(){
        if($rootScope.authenticated)
        {
            console.log('Forced Logout');
            window.location.href="#/logout";
        }
        ///////////////////////////////////////////////////
        /// redirect to another page(eg. Login.html) here
        ///////////////////////////////////////////////////
    }

    function TimeOut_Resetter(e){
        //console.log(' ' + e);
        //console.log($rootScope.authenticated);
        /// Stop the pending timeout
        //if(TimeOut_Thread!=null)
        $timeout.cancel(TimeOut_Thread);

        /// Reset the timeout
        if($rootScope.authenticated)
        TimeOut_Thread = $timeout(function(){ LogoutByTimer() } , TimeOutTimerValue);
    }

});


/*
 app.directive('exportToPdf', function(){
       
       return {
           restrict: 'E',
           scope: {
                elemId: '@',
                fileName:'@'
                
           },
           //template: '<button data-ng-click="exportToPdf()">Export to PDF</button>',
           template: '<a ng-click="exportToPdf()">Export to PDF</a>',

           link: function(scope, elem, attr){

              scope.exportToPdf = function() {

                
                  var margins = {
                    top: 10,
                    bottom: 60,
                    left: 10,
                    width: 800
                  };
              
                  var doc = new jsPDF({unit:'px', format:'a4'});
                  //var doc = new jsPDF("p", "mm", "a4");

                    //var width = doc.internal.pageSize.width;    
                    //var height = doc.internal.pageSize.height;
                  //console.log(width+' : '+height);
                 // doc.internal.pageSize.width = 800;
                  doc.setProperties({
                     title: 'Title',
                     subject: 'This is the subject',
                     author: 'Author Name',
                     keywords: 'generated, javascript, web 2.0, ajax',
                     creator: 'Creator Name'
                    });
                  console.log('elemId 12312321', scope.elemId);
                           
                  doc.fromHTML(
                  document.getElementById(scope.elemId).innerHTML);
                  
                  doc.save(scope.fileName+'.pdf');
                   
               }
           }                   
       }
    
    });    

    */

app.factory('Utils', function() {
  var service = {
     isUndefinedOrNull: function(obj) {
         return !angular.isDefined(obj) || obj===null;
     }

  }

  return service;
});

app.factory('preventTemplateCache', function() {
    var ENV1 = Math.random();
    var ENV2 = Math.random();
return {
      'request': function(config) {
        //if (config.url.indexOf('partials') !== -1) {
            if (config.url.indexOf('template') === -1 && config.url.indexOf('angular-ui-notification') === -1)
                config.url = config.url + '?t=' + ENV1+ENV2;
        //}
        return config;
      }
    }
  });

app.config(function($httpProvider) {
    $httpProvider.interceptors.push('preventTemplateCache');
  });

app.config(['ngDialogProvider', function (ngDialogProvider) {
            ngDialogProvider.setDefaults({
                className: 'ngdialog-theme-default',
                plain: false,
                showClose: false,
                closeByDocument: true,
                closeByEscape: true,
                appendTo: false,
                preCloseCallback: function () {
                    console.log('default pre-close callback');
                }
            });
        }]);

app.directive("datepicker", function () {
  return {
    restrict: "A",
    require: "ngModel",
    link: function (scope, elem, attrs, ngModelCtrl) {
      var updateModel = function (dateText) {
        scope.$apply(function () {
          ngModelCtrl.$setViewValue(dateText);
        });
      };
      var options = {
        dateFormat: "dd/mm/yy",
        onSelect: function (dateText) {
          updateModel(dateText);
        }
      };
      elem.datepicker(options);
    }
  }
});


/*
app.run(function($rootScope, $templateCache,$cacheFactory) {
   $rootScope.$on('$viewContentLoaded', function() {
     
     console.log($cacheFactory);
         angular.forEach($templateCache, function(cacheobj) {
            console.log(cacheobj);
        });
   });
});
*/

 app.directive('validNumber', function() {
      return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
          if(!ngModelCtrl) {
            return; 
          }

          ngModelCtrl.$parsers.push(function(val) {
            if (angular.isUndefined(val)) {
                var val = '';
            }
            
            var clean = val.replace(/[^-0-9\.]/g, '');
            var negativeCheck = clean.split('-');
			var decimalCheck = clean.split('.');
            if(!angular.isUndefined(negativeCheck[1])) {
                negativeCheck[1] = negativeCheck[1].slice(0, negativeCheck[1].length);
                clean =negativeCheck[0] + '-' + negativeCheck[1];
                if(negativeCheck[0].length > 0) {
                	clean =negativeCheck[0];
                }
                
            }
              
            if(!angular.isUndefined(decimalCheck[1])) {
                decimalCheck[1] = decimalCheck[1].slice(0,2);
                clean =decimalCheck[0] + '.' + decimalCheck[1];
            }

            if (val !== clean) {
              ngModelCtrl.$setViewValue(clean);
              ngModelCtrl.$render();
            }
            return clean;
          });

          element.bind('keypress', function(event) {
            if(event.keyCode === 32) {
              event.preventDefault();
            }
          });
        }
      };
 });
	  
app.directive('ukdate', function (dateFilter) {
    return {
        require:'ngModel',
        link:function (scope, elm, attrs, ctrl) {

            var dateFormat = attrs['ukdate'] || 'dd-MM-yyyy';
           
            ctrl.$formatters.unshift(function (modelValue) {
                return dateFilter(modelValue, dateFormat);
            });
        }
    };
    });

app.directive('customDatepicker',function($compile){
        return {
            replace:true,
            templateUrl:'custom-datepicker.html',
            scope: {
                ngModel: '=',
                dateOptions: '='
            },
            link: function($scope, $element, $attrs, $controller){
                var $button = $element.find('button');
                var $input = $element.find('input');
                $button.on('click',function(){
                    if($input.is(':focus')){
                        $input.trigger('blur');
                    } else {
                        $input.trigger('focus');
                    }
                });
            }    
        };
    });

  




app.factory('Excel',function($window){
        var uri='data:application/vnd.ms-excel;base64,',
            template='<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64=function(s){return $window.btoa(unescape(encodeURIComponent(s)));},
            format=function(s,c){return s.replace(/{(\w+)}/g,function(m,p){return c[p];})};
        return {
            tableToExcel:function(tableId,worksheetName){
                var table=$(tableId),
                    ctx={worksheet:worksheetName,table:table.html()},
                    href=uri+base64(format(template,ctx));
                return href;
            }
        };
    });

	
app.directive('fileModel', ['$parse', function ($parse) {
            return {
               restrict: 'A',
               link: function(scope, element, attrs) {
                  var model = $parse(attrs.fileModel);
                  var modelSetter = model.assign;
                  element.bind('change', function(){
                     scope.$apply(function(){
                        modelSetter(scope, element[0].files[0]);
                     });
                  });
               }
            };
         }]);
	
// I run during the application bootstrap and hook the $http activity into the
        // trafficCop service so we can monitor the activity.
        app.config(
            function setupConfig( $httpProvider ) {
                // Wire up the traffic cop interceptors. This method will be invoked with
                // full dependency-injection functionality.
                // --
                // NOTE: This approach has been available since AngularJS 1.1.4.
                
                $httpProvider.interceptors.push( interceptHttp );
                // We're going to TRY to track the outgoing and incoming HTTP requests.
                // I stress "TRY" because in a perfect world, this would be very easy
                // with the promise-based interceptor chain; but, the world of
                // interceptors and data transformations is a cruel she-beast. Any
                // interceptor may completely change the outgoing config or the incoming
                // response. As such, there's a limit to the accuracy we can provide.
                // That said, it is very unlikely that this will break; but, even so, I
                // have some work-arounds for unfortunate edge-cases.
                function interceptHttp( $q, trafficCop ) {
                    // Return the interceptor methods. They are all optional and get
                    // added to the underlying promise chain.

                    return({
                        request: request,
                        requestError: requestError,
                        response: response,
                        responseError: responseError
                    });
                    // ---
                    // PUBLIC METHODS.
                    // ---
                    // Intercept the request configuration.
                    function request( config ) {


                        // NOTE: We know that this config object will contain a method as
                        // this is the definition of the interceptor - it must accept a
                        // config object and return a config object.
                        //console.log(config.url);
                       // var str = config.url;
                       // var myarray = str.split('/');
                       // console.log(isInArray(myarray[2],excludedRequests));
                       // if(!isInArray(myarray[2],excludedRequests))
                       // {
                        trafficCop.startRequest( config.method );
                        // Pass-through original config object.
                        return( config );
                       // }
                    }
                    // Intercept the failed request.
                    function requestError( rejection ) {
                        // At this point, we don't why the outgoing request was rejected.
                        // And, we may not have access to the config - the rejection may
                        // be an error object. As such, we'll just track this request as
                        // a "GET".
                        // --
                        // NOTE: We can't ignore this one since our responseError() would
                        // pick it up and we need to be able to even-out our counts.
                        trafficCop.startRequest( "get" );
                        // Pass-through the rejection.
                        return( $q.reject( rejection ) );
                    }

                    
                    // Intercept the successful response.
                    function response( response ) {

                        

                        trafficCop.endRequest( extractMethod( response ),response );
                        // Pass-through the resolution.
                        return( response );
                    }
                    // Intercept the failed response.
                    function responseError( response ) {
                        trafficCop.endRequest( extractMethod( response ), response );
                        // Pass-through the rejection.
                        return( $q.reject( response ) );
                    }
                    // ---
                    // PRIVATE METHODS.
                    // ---
                    // I attempt to extract the HTTP method from the given response. If
                    // another interceptor has altered the response (albeit a very
                    // unlikely occurrence), then we may not be able to access the config
                    // object or the the underlying method. If this fails, we return GET.
                    function extractMethod( response ) {

                        try {
                            return( response.config.method );
                        } catch ( error ) {
                            return( "get" );
                        }
                    }
                }
            }
        );
        // I keep track of the total number of HTTP requests that have been initiated
        // and completed in the application. I work in conjunction with an HTTP
        // interceptor that pipes data from the $http service into get/end methods.
        
		app.service(
            "trafficCop",
            function setupService() {
                // I keep track of the total number of HTTP requests that have been
                // initiated with the application.
                var total = {
                    all: 0,
                    get: 0,
                    post: 0,
                    delete: 0,
                    put: 0,
                    head: 0
                };
                
                // I keep track of the total number of HTTP requests that have been
                // initiated, but have not yet completed (ie, are still running).
                var pending = {
                    all: 0,
                    get: 0,
                    post: 0,
                    delete: 0,
                    put: 0,
                    head: 0,
                    url : ''
                };
                // Return the public API.
                return({
                    pending: pending,
                    total: total,
                    endRequest: endRequest,
                    startRequest: startRequest,
                    
                });
                // ---
                // PUBLIC METHODS.
                // ---
                // I stop tracking the given HTTP request.
                function endRequest( httpMethod, responseobj ) {
                    //console.log(responseobj.config.url);
                    //responseCol = responseobj;
                    pending.url = responseobj.config.url;
                    httpMethod = normalizedHttpMethod( httpMethod );
                    pending.all--;
                    pending[ httpMethod ]--;
                    // EDGE CASE: In the unlikely event that the interceptors were not
                    // able to obtain the config object; or, the method was changed after
                    // our interceptor reached it, there's a chance that our numbers will
                    // be off. In such a case, we want to try to redistribute negative
                    // counts onto other properties.
                    if ( pending[ httpMethod ] < 0 ) {
                        redistributePendingCounts( httpMethod );
                    }
                }
                // I start tracking the given HTTP request.
                function startRequest( httpMethod ) {
                    httpMethod = normalizedHttpMethod( httpMethod );
                    total.all++;
                    total[ httpMethod ]++;
                    pending.all++;
                    pending[ httpMethod ]++;
                }
                // ---
                // PRIVATE METHODS.
                // ---
                // I make sure the given HTTP method is recognizable. If it's not, it is
                // converted to "get" for consumption.
                function normalizedHttpMethod( httpMethod ) {
                    httpMethod = ( httpMethod || "" ).toLowerCase();
                    switch ( httpMethod ) {
                        case "get":
                        case "post":
                        case "delete":
                        case "put":
                        case "head":
                            return( httpMethod );
                        break;
                    }
                    return( "get" );
                }
                // I attempt to redistribute an [unexpected] negative count to other
                // non-negative counts. The HTTP methods are iterated in likelihood of
                // execution. And, while this isn't an exact science, it will normalize
                // after all HTTP requests have finished processing.
                function redistributePendingCounts( negativeMethod ) {
                    var overflow = Math.abs( pending[ negativeMethod ] );
                    pending[ negativeMethod ] = 0;
                    // List in likely order of precedence in the application.
                    var methods = [ "get", "post", "delete", "put", "head" ];
                    // Trickle the overflow across the list of methods.
                    for ( var i = 0 ; i < methods.length ; i++ ) {
                        var method = methods[ i ];
                        if ( overflow && pending[ method ] ) {
                            pending[ method ] -= overflow;
                            if ( pending[ method ] < 0 ) {
                                overflow = Math.abs( pending[ method ] );
                                pending[ method ] = 0;
                            } else {
                                overflow = 0;
                            }
                        }
                    }
                }
            }
        );


/*
app.config(['$provide', function($provide) {
  $provide.decorator('selectDirective', ['$delegate', function($delegate) {
    var directive = $delegate[0];

    directive.compile = function() {
alert('222');
      function post(scope, element, attrs, ctrls) {
        alert('222');
        if(typeof directive.link.post === 'undefined')
        {

        }
        else
{

        directive.link.post.apply(this, arguments);

        var ngModelController = ctrls[1];
        if (ngModelController && attrs.multiSelect !== null) {
          originalRender = ngModelController.$render;
          ngModelController.$render = function() {
            originalRender();
            element.multiselect('refresh');
          };
        }
    }
      }

      return {
        pre: directive.link.pre,
        post: post
      };
    };

    return $delegate;
  }]);
}]);
*/

app.directive('ngDropdownMultiselect', ['$filter', '$document', '$compile', '$parse',

function ($filter, $document, $compile, $parse) {

    return {
        restrict: 'AE',
        scope: {
            selectedModel: '=',
            options: '=',
            extraSettings: '=',
            events: '=',
            searchFilter: '=?',
            translationTexts: '=',
            groupBy: '@'
        },
        template: function (element, attrs) {
            var checkboxes = attrs.checkboxes ? true : false;
            var groups = attrs.groupBy ? true : false;

            var template = '<div class="multiselect-parent btn-group dropdown-multiselect">';
            template += '<button type="button" class="dropdown-toggle" ng-class="settings.buttonClasses" ng-click="toggleDropdown()">{{getButtonText()}}&nbsp;<span class="caret"></span></button>';
            template += '<ul class="dropdown-menu dropdown-menu-form" ng-style="{display: open ? \'block\' : \'none\', height : settings.scrollable ? settings.scrollableHeight : \'auto\' }" style="overflow: scroll" >';
            template += '<li ng-hide="!settings.showCheckAll || settings.selectionLimit > 0"><a data-ng-click="selectAll()"><span class="glyphicon glyphicon-ok"></span>  {{texts.checkAll}}</a>';
            template += '<li ng-show="settings.showUncheckAll"><a data-ng-click="deselectAll();"><span class="glyphicon glyphicon-remove"></span>   {{texts.uncheckAll}}</a></li>';
            template += '<li ng-hide="(!settings.showCheckAll || settings.selectionLimit > 0) && !settings.showUncheckAll" class="divider"></li>';
            template += '<li ng-show="settings.enableSearch"><div class="dropdown-header"><input type="text" class="form-control" style="width: 100%;" ng-model="searchFilter" placeholder="{{texts.searchPlaceholder}}" /></li>';
            template += '<li ng-show="settings.enableSearch" class="divider"></li>';

            if (groups) {
                template += '<li ng-repeat-start="option in orderedItems | filter: searchFilter" ng-show="getPropertyForObject(option, settings.groupBy) !== getPropertyForObject(orderedItems[$index - 1], settings.groupBy)" role="presentation" class="dropdown-header">{{ getGroupTitle(getPropertyForObject(option, settings.groupBy)) }}</li>';
                template += '<li ng-repeat-end role="presentation">';
            } else {
                template += '<li role="presentation" ng-repeat="option in options | filter: searchFilter">';
            }

            template += '<a role="menuitem" tabindex="-1" ng-click="setSelectedItem(getPropertyForObject(option,settings.idProp))">';

            if (checkboxes) {
                template += '<div class="checkbox"><label><input class="checkboxInput" type="checkbox" ng-click="checkboxClick($event, getPropertyForObject(option,settings.idProp))" ng-checked="isChecked(getPropertyForObject(option,settings.idProp))" /> {{getPropertyForObject(option, settings.displayProp)}}</label></div></a>';
            } else {
                template += '<span data-ng-class="{\'glyphicon glyphicon-ok\': isChecked(getPropertyForObject(option,settings.idProp))}"></span> {{getPropertyForObject(option, settings.displayProp)}}</a>';
            }

            template += '</li>';

            template += '<li class="divider" ng-show="settings.selectionLimit > 1"></li>';
            template += '<li role="presentation" ng-show="settings.selectionLimit > 1"><a role="menuitem">{{selectedModel.length}} {{texts.selectionOf}} {{settings.selectionLimit}} {{texts.selectionCount}}</a></li>';

            template += '</ul>';
            template += '</div>';

            element.html(template);
        },
        link: function ($scope, $element, $attrs) {
            var $dropdownTrigger = $element.children()[0];

            $scope.toggleDropdown = function () {
                //alert('3333');
                $scope.open = !$scope.open;
            };

            $scope.checkboxClick = function ($event, id) {
                $scope.setSelectedItem(id);
                $event.stopImmediatePropagation();
            };

            $scope.externalEvents = {
                onItemSelect: angular.noop,
                onItemDeselect: angular.noop,
                onSelectAll: angular.noop,
                onDeselectAll: angular.noop,
                onInitDone: angular.noop,
                onMaxSelectionReached: angular.noop
            };

            $scope.settings = {
                dynamicTitle: true,
                scrollable: false,
                scrollableHeight: '300px',
                closeOnBlur: true,
                displayProp: 'label',
                idProp: 'id',
                externalIdProp: 'id',
                enableSearch: false,
                selectionLimit: 0,
                showCheckAll: true,
                showUncheckAll: true,
                closeOnSelect: false,
                buttonClasses: 'btn btn-default',
                closeOnDeselect: false,
                groupBy: $attrs.groupBy || undefined,
                groupByTextProvider: null,
                smartButtonMaxItems: 0,
                smartButtonTextConverter: angular.noop
            };

            $scope.texts = {
                checkAll: 'Check All',
                uncheckAll: 'Uncheck All',
                selectionCount: 'checked',
                selectionOf: '/',
                searchPlaceholder: 'Search...',
                buttonDefaultText: 'Select',
                dynamicButtonTextSuffix: 'checked'
            };

            $scope.searchFilter = $scope.searchFilter || '';

            if (angular.isDefined($scope.settings.groupBy)) {
                $scope.$watch('options', function (newValue) {
                    if (angular.isDefined(newValue)) {
                        $scope.orderedItems = $filter('orderBy')(newValue, $scope.settings.groupBy);
                    }
                });
            }

            angular.extend($scope.settings, $scope.extraSettings || []);
            angular.extend($scope.externalEvents, $scope.events || []);
            angular.extend($scope.texts, $scope.translationTexts);

            $scope.singleSelection = $scope.settings.selectionLimit === 1;

            function getFindObj(id) {
                var findObj = {};

                if ($scope.settings.externalIdProp === '') {
                    findObj[$scope.settings.idProp] = id;
                } else {
                    findObj[$scope.settings.externalIdProp] = id;
                }

                return findObj;
            }

            function clearObject(object) {
                for (var prop in object) {
                    delete object[prop];
                }
            }

            if ($scope.singleSelection) {
                if (angular.isArray($scope.selectedModel) && $scope.selectedModel.length === 0) {
                    clearObject($scope.selectedModel);
                }
            }

            if ($scope.settings.closeOnBlur) {
                $document.on('click', function (e) {
                    var target = e.target.parentElement;
                    var parentFound = false;

                    while (angular.isDefined(target) && target !== null && !parentFound) {
                        if (_.contains(target.className.split(' '), 'multiselect-parent') && !parentFound) {
                            if (target === $dropdownTrigger) {
                                parentFound = true;
                            }
                        }
                        target = target.parentElement;
                    }

                    if (!parentFound) {
                        $scope.$apply(function () {
                            $scope.open = false;
                        });
                    }
                });
            }

            $scope.getGroupTitle = function (groupValue) {
                if ($scope.settings.groupByTextProvider !== null) {
                    return $scope.settings.groupByTextProvider(groupValue);
                }

                return groupValue;
            };

            $scope.getButtonText = function () {
                if ($scope.settings.dynamicTitle && ($scope.selectedModel.length > 0 || (angular.isObject($scope.selectedModel) && _.keys($scope.selectedModel).length > 0))) {
                    if ($scope.settings.smartButtonMaxItems > 0) {
                        var itemsText = [];

                        angular.forEach($scope.options, function (optionItem) {
                            if ($scope.isChecked($scope.getPropertyForObject(optionItem, $scope.settings.idProp))) {
                                var displayText = $scope.getPropertyForObject(optionItem, $scope.settings.displayProp);
                                var converterResponse = $scope.settings.smartButtonTextConverter(displayText, optionItem);

                                itemsText.push(converterResponse ? converterResponse : displayText);
                            }
                        });

                        if ($scope.selectedModel.length > $scope.settings.smartButtonMaxItems) {
                            itemsText = itemsText.slice(0, $scope.settings.smartButtonMaxItems);
                            itemsText.push('...');
                        }

                        return itemsText.join(', ');
                    } else {
                        var totalSelected;

                        if ($scope.singleSelection) {
                            totalSelected = ($scope.selectedModel !== null && angular.isDefined($scope.selectedModel[$scope.settings.idProp])) ? 1 : 0;
                        } else {
                            totalSelected = angular.isDefined($scope.selectedModel) ? $scope.selectedModel.length : 0;
                        }

                        if (totalSelected === 0) {
                            return $scope.texts.buttonDefaultText;
                        } else {
                            return totalSelected + ' ' + $scope.texts.dynamicButtonTextSuffix;
                        }
                    }
                } else {
                    return $scope.texts.buttonDefaultText;
                }
            };

            $scope.getPropertyForObject = function (object, property) {
                if (angular.isDefined(object) && object.hasOwnProperty(property)) {
                    return object[property];
                }

                return '';
            };

            $scope.selectAll = function () {
                $scope.deselectAll(false);
                $scope.externalEvents.onSelectAll();

                angular.forEach($scope.options, function (value) {
                    $scope.setSelectedItem(value[$scope.settings.idProp], true);
                });
            };

            $scope.deselectAll = function (sendEvent) {
                sendEvent = sendEvent || true;

                if (sendEvent) {
                    $scope.externalEvents.onDeselectAll();
                }

                if ($scope.singleSelection) {
                    clearObject($scope.selectedModel);
                } else {
                    $scope.selectedModel.splice(0, $scope.selectedModel.length);
                }
            };

            $scope.setSelectedItem = function (id, dontRemove) {
                var findObj = getFindObj(id);
                var finalObj = null;

                if ($scope.settings.externalIdProp === '') {
                    finalObj = _.find($scope.options, findObj);
                } else {
                    finalObj = findObj;
                }

                if ($scope.singleSelection) {
                    clearObject($scope.selectedModel);
                    angular.extend($scope.selectedModel, finalObj);
                    $scope.externalEvents.onItemSelect(finalObj);
                    if ($scope.settings.closeOnSelect) $scope.open = false;

                    return;
                }

                dontRemove = dontRemove || false;

                var exists = _.findIndex($scope.selectedModel, findObj) !== -1;

                if (!dontRemove && exists) {
                    $scope.selectedModel.splice(_.findIndex($scope.selectedModel, findObj), 1);
                    $scope.externalEvents.onItemDeselect(findObj);
                } else if (!exists && ($scope.settings.selectionLimit === 0 || $scope.selectedModel.length < $scope.settings.selectionLimit)) {
                    $scope.selectedModel.push(finalObj);
                    $scope.externalEvents.onItemSelect(finalObj);
                }
                if ($scope.settings.closeOnSelect) $scope.open = false;
            };

            $scope.isChecked = function (id) {
                if ($scope.singleSelection) {
                    return $scope.selectedModel !== null && angular.isDefined($scope.selectedModel[$scope.settings.idProp]) && $scope.selectedModel[$scope.settings.idProp] === getFindObj(id)[$scope.settings.idProp];
                }

                return _.findIndex($scope.selectedModel, getFindObj(id)) !== -1;
            };

            $scope.externalEvents.onInitDone();
        }
    };
}]);

