

var usermgmtCtrl = app.controller('messageCtrl', function ($scope,$route, $rootScope, $routeParams, $location, $http, Data, $filter) {
    //initially set those objects to null to avoid undefined error

	$scope.IsMessageListLoading = false;
	$scope.messagesList = null;
	$scope.selectedMessage = null;
	$scope.EnteredMessageText = "";
	$scope.AddMessageFormValues = {'SendTo':1,'SendToList':'','SelectedUsers':'','SelectedRoles':'','Settings':'','Subject':'','Message':''};
	$scope.AddMessageFormValues.SendTo = '1'; // send to user
	$scope.AddMessageFormValues.SendToList = [{'ID':'1','Name':'Users'},{'ID':'2','Name':'Roles'}];
	
$scope.AddMessageFormValues.SelectedUsers = [];
$scope.AddMessageFormValues.SelectedRoles = [];
    $scope.AddMessageFormValues.Settings = {
        scrollableHeight: '400px',
        scrollable: true,
        enableSearch: true
    };
    $scope.AddMessageFormValues.Subject = '';
    $scope.AddMessageFormValues.Message = '';



	$scope.Messagespredicate = 'Name';  
       $scope.Messagesreverse = true;  
       $scope.MessagescurrentPage = 1;  
	   
       $scope.Messagesorder = function (predicate) {  
         $scope.Messagesreverse = ($scope.Messagespredicate === predicate) ? !$scope.Messagesreverse : false;  
         $scope.Messagespredicate = predicate;  
       };  
	   
	   
       $scope.MessagesnumPerPage = 15;  
       $scope.Messagespaginate = function (value) {  
         var begin, end, index;  
         begin = ($scope.MessagescurrentPage - 1) * $scope.MessagesnumPerPage;  
         end = begin + $scope.MessagesnumPerPage;  
         index = $scope.messagesList.indexOf(value);  
         return (begin <= index && index < end);  
       };  


       $scope.selectByGroupModel = []; 
       $scope.selectByGroupData = [ { id: 1, label: "David", gender: 'M' }, { id: 2, label: "Jhon", gender: 'M' }, { id: 3, label: "Lisa", gender: 'F' }, { id: 4, label: "Nicole", gender: 'F' }, { id: 5, label: "Danny", gender: 'M' }, {	id: 6, label: "Unknown", gender: 'O' } ]; $scope.selectByGroupSettings = { selectByGroups: ['F', 'M'], groupByTextProvider: function(groupValue) { switch (groupValue) { case 'M': return 'Male'; case 'F': return 'Female'; case 'O': return 'Other'; } }, groupBy: 'gender', };


	$scope.LoadAllMessages = function()
	{

			$scope.IsMessageListLoading = true;
			Data.Addtoast("info","Loading Messages");
			Data.post('GetAllContactFormMessages').then(function (results) {
				//alert(results.Titles);
				$scope.messagesList = results.data;
				$scope.MessagestotalItems = $scope.messagesList.length;  
				$scope.IsMessageListLoading = false;
				//alert($scope.users.length);
				//thisObj.setMygrid();   
            });
		//}
	}

	$scope.LoadSelectedMessage = function(MessageID)
	{

			$scope.IsMessageListLoading = true;
			Data.Addtoast("info","Loading Messages");
			Data.post('GetContactFormMessage',{
				dparams: {'MessageID':MessageID} }
				).then(function (results) {
				//alert(results.Titles);
				$scope.selectedMessage = results.selectedMessage[0]; 
				$scope.messagesList = results.selectedMessageThread;
				$scope.MessagestotalItems = $scope.messagesList.length;  
				$scope.IsMessageListLoading = false;
				//alert($scope.users.length);
				//thisObj.setMygrid();   
            });
		//}
	}

	$scope.DeleteContactFormMessage = function(item)
	{
		if(confirm('Do you really want to delete this message ?'))
		{
			$scope.IsMessageListLoading = true;
			
			Data.post('DeleteContactFormMessage',{
				dparams: {'ID':item.ID} }
				).then(function (results) {
					Data.toast(results);
					$scope.Load();
            });
		//}
		}
	}

	$scope.SubmitMessageThread = function()
	{

			//$scope.IsMessageListLoading = true;
			//Data.Addtoast("info","Loading Messages");
			Data.post('SubmitMessageThread',{
				dparams: {'MessageID':$routeParams.id,'Message':$scope.EnteredMessageText} }
				).then(function (results) {
					if(results.status=='success')
					{
						Data.toast(results);
						$scope.LoadSelectedMessage($routeParams.id);
					}  
            });
		//}
	}

	$scope.PrepareAddMessageForm = function()
	{

			//$scope.IsMessageListLoading = true;
			//Data.Addtoast("info","Loading Messages");
			Data.post('PrepareAddMessageForm'
				).then(function (results) {
					if(results.status=='success')
					{
						//Data.toast(results);
						//$scope.LoadSelectedMessage($routeParams.id);
						$scope.AddMessageFormValues.data = results.data;
					}  
            });
		//}
	}

	$scope.IsAdmin = function()
	{
		//alert($rootScope.isadmin);
		return $rootScope.isadmin;
	}

	$scope.LoggedUserID = function()
	{
		//alert($rootScope.isadmin);
		return $rootScope.uid;
	}
	

	$scope.AddNewMessageByAdmin = function()
	{

			//$scope.IsMessageListLoading = true;
			//Data.Addtoast("info","Loading Messages");
			Data.post('AddNewMessageByAdmin',{
				dparams:  $scope.AddMessageFormValues  }
				).then(function (results) {
					if(results.status=='success')
					{
						Data.toast(results);
						//$scope.LoadSelectedMessage($routeParams.id);
					}  
            });
		//}
	}


$scope.formatDateTimeUK = function(date){
     		//alert(date);
          //var dateOut = new Date(date);
          var dateOut = new Date(date.replace(/-/g,"/"));
          dateOut = $filter('date')(dateOut, "dd-MM-yyyy HH:mm:ss");
           // alert(dateOut);
          return dateOut;
    };
	$scope.Load = function()
	{
		var nextUrl = $route.current.$$route.originalPath;

        if (nextUrl == '/message/add') {
        	//alert(nextUrl);
        	$scope.PrepareAddMessageForm();
        }
		else if($routeParams.id==null)
		{
			//alert('all');
				$scope.LoadAllMessages();
		}
		else
		{
			$scope.LoadSelectedMessage($routeParams.id);
		}
	}

	$scope.Load();
	
	
	
});

