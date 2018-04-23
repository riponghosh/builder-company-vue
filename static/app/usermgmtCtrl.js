  function HtmlExportToPDF(ElementID, FileName) {
 
		var doc = new jsPDF('p', 'mm', [700, 1000]);
		                  var margins = {
		        top: 5,
		        bottom: 5,
		        left: 5
		        
		    };
		                  doc.setProperties({
		                     title: 'Title',
		                     subject: 'This is the subject',
		                     author: 'Author Name',
		                     keywords: 'generated, javascript, web 2.0, ajax',
		                     creator: 'Creator Name'
		                    });
		                 
		                  doc.fromHTML(
		                  document.getElementById(ElementID).innerHTML,margins.left, // x coord
		    margins.top);
                  
                  doc.save(FileName+'.pdf');
}

 function setMygrid()
 {
            $('#dataTables-example').dataTable();
}
function calljqueryScripts()
{

//$('#test').BootSideMenu({side:"left", autoClose:false});
// $('#test').BootSideMenu({side:"left",autoClose:true});
 //$('#test2').BootSideMenu({side:"right"});
//alert('here');
	 /*$('.btn-toggle').click(function() {
	    $(this).find('.btn').toggleClass('active');  
	    
	    
	 
	    if ($(this).find('.btn-success').size()>0) {
	    	$(this).find('.btn').toggleClass('btn-success');
	    }
	 
	    
	    $(this).find('.btn').toggleClass('btn-default');
	       
	});*/
}
var thisObj = this;

var usermgmtCtrl = app.controller('usermgmtCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, $filter,$timeout) {
    //initially set those objects to null to avoid undefined error
	
    $scope.logoutUser = function () {
		//alert('fromm profile ctrl');
        $rootScope.$emit('logoutEvent',{});
    };
    $scope.isUserEditLoading = true;
    $scope.UserEditErrorMessage = "";
	$scope.IsUserListLoading = true;
	$scope.IsTitlesListLoading = true;
	$scope.IsRolesListLoading = true;
	$scope.IsSettingsLoading = true;
	$scope.titles = null;
	$scope.roles = null;
	$scope.ObservationStatusList = null;
	$scope.AddRoleToObservationStatusForm = null;
	$scope.EditingTitleForRole = null;
	$scope.users = null;
	$scope.AllTitles = null;
	$scope.FormType = 'ADD';
	$scope.TitleFormType = 'LIST';
	$scope.RoleFormType = 'LIST';
	$scope.user = {"ID":"0","Username":"","Password":"","Email":"","Firstname":"","Lastname":"","CreatedDate":"","IsAdmin":"","Active":"","Mobile":"","ConfirmPassword":"","Title":"","Notes":"","userhotels":null};
	$scope.Title = {"ID":"0","Name":""};
	$scope.Role = {"ID":"0","Name":""};
	
		$scope.predicate = 'Username';  
       $scope.reverse = false;  
       $scope.currentPage = 1;  
	   
       $scope.order = function (predicate) {  
         $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;  
         $scope.predicate = predicate;  
       };  
	   
	   
       $scope.numPerPage = 15;  
       $scope.paginate = function (value) {  
         var begin, end, index;  
         begin = ($scope.currentPage - 1) * $scope.numPerPage;  
         end = begin + $scope.numPerPage;  
         index = $scope.users.indexOf(value);  
         return (begin <= index && index < end);  
       };  


       $scope.UserHotelspredicate = 'ID';  
       $scope.UserHotelsreverse = true;  
       $scope.UserHotelscurrentPage = 1;  
	   
       $scope.UserHotelsorder = function (predicate) {  
         $scope.UserHotelsreverse = ($scope.UserHotelspredicate === predicate) ? !$scope.UserHotelsreverse : false;  
         $scope.UserHotelspredicate = predicate;  
       };  
	   
	   
       $scope.UserHotelsnumPerPage = 15;  
       $scope.UserHotelspaginate = function (value) {  
         var begin, end, index;  
         begin = ($scope.UserHotelscurrentPage - 1) * $scope.UserHotelsnumPerPage;  
         end = begin + $scope.UserHotelsnumPerPage;  
         index = $scope.user.userhotels.indexOf(value);  
         return (begin <= index && index < end);  
       };  
	   
	   
	   $scope.Titlespredicate = 'Name';  
       $scope.Titlesreverse = false;  
       $scope.TitlescurrentPage = 1;  
	   
       $scope.Titlesorder = function (predicate) {  
         $scope.Titlesreverse = ($scope.Titlespredicate === predicate) ? !$scope.Titlesreverse : false;  
         $scope.Titlespredicate = predicate;  
       };  
	   
	   
       $scope.TitlesnumPerPage = 15;  
       $scope.Titlespaginate = function (value) {  
         var begin, end, index;  
         begin = ($scope.TitlescurrentPage - 1) * $scope.TitlesnumPerPage;  
         end = begin + $scope.TitlesnumPerPage;  
         index = $scope.titles.indexOf(value);  
         return (begin <= index && index < end);  
       };  
	   
	   
	   $scope.Rolespredicate = 'Name';  
       $scope.Rolesreverse = true;  
       $scope.RolescurrentPage = 1;  
	   
       $scope.Rolesorder = function (predicate) {  
         $scope.Rolesreverse = ($scope.Rolespredicate === predicate) ? !$scope.reverse : false;  
         $scope.Rolespredicate = predicate;  
       };  
	   
	   
       $scope.RolesnumPerPage = 100;  
       $scope.Rolespaginate = function (value) {  
         var begin, end, index;  
         begin = ($scope.RolescurrentPage - 1) * $scope.RolesnumPerPage;  
         end = begin + $scope.RolesnumPerPage;  
         index = $scope.roles.indexOf(value);  
         return (begin <= index && index < end);  
       };  

       $scope.RolesToStatuspredicate = 'StatusName';  
       $scope.RolesToStatusreverse = false;  
       $scope.RolesToStatuscurrentPage = 1;  
	   
       $scope.RolesToStatusorder = function (predicate) {  
         $scope.RolesToStatusreverse = ($scope.RolesToStatuspredicate === predicate) ? !$scope.RolesToStatusreverse : false;  
         $scope.RolesToStatuspredicate = predicate;  
       };  
       $scope.RolesToStatusnumPerPage = 1000;  
       $scope.RolesToStatuspaginate = function (value) {  
         var begin, end, index;  
         begin = ($scope.RolesToStatuscurrentPage - 1) * $scope.RolesToStatusnumPerPage;  
         end = begin + $scope.RolesToStatusnumPerPage;  
         index = $scope.ObservationStatusList.indexOf(value);  
         return (begin <= index && index < end);  
       };  
	
	$scope.doUpdateProfile = function (user) {
		
		//alert($scope.AllTitles);
		//if(user.Active=='true')
			//alert(user.Active);
		user.Active = (user.Active?1:0);
		user.From='usermgmt';
		if(user.ID>0)
		{
			//alert(user.Active);
			Data.post('updateprofile', {
				user: user
			}).then(function (results) {
				//Data.toast(results);
				if (results.status == "success") {
					Data.toast(results);
				}
			});
		}
		else
		{
			Data.post('AddNewUser', {
				user: user
			}).then(function (results) {
				Data.toast(results);
				if (results.status == "success") {
					$location.path('usermgmt/view/'+results.uid);
				}
			});
		}
    };
	
	$scope.doDeleteUser = function (Deluser) {
		
		if(confirm('Do you really want to delete this user ?'))
		{
			//alert(Deluser.ID);
			Data.post('DeleteUser', {
				user: Deluser
			}).then(function (results) {
				
				if (results.status == "success") {
					
					$scope.users.splice($scope.users.indexOf(Deluser), 1);
					$scope.totalItems = $scope.users.length;  
					Data.toast(results);
				}
				else
				{
					Data.toast(results);
				}
			});
		}
    };
    $scope.doDeleteRoleToObservationStatus = function (DelItem) {
		
		if(confirm('Do you really want to delete this Status ?'))
		{
			//alert(Deluser.ID);
			Data.post('DeleteRoleToObservationStatus', {
				item: DelItem
			}).then(function (results) {
				
				if (results.status == "success") {
					
					$scope.ObservationStatusList.splice($scope.ObservationStatusList.indexOf(DelItem), 1);
					$scope.RolesToStatustotalItems = $scope.ObservationStatusList.length;  
					Data.toast(results);
				}
				else
				{
					Data.toast(results);
				}
			});
		}
    };

    $scope.PrepareAddRoleToObservationStatus = function () {
		

			//alert(Deluser.ID);
			Data.post('PrepareAddRoleToObservationStatus', {
				item: $scope.Role
			}).then(function (results) {
				
				//if (results.status == "success") {
					
					$scope.AddRoleToObservationStatusForm = results.AddRoleToObservationStatus.Data[0];
				//}
				
			});
		
    };
	
	$scope.doDeleteUserHotel = function (Deluserhotel) {
		

			//alert(Deluser.ID);
			Data.post('DeleteUserHotel', {
				userhotel: Deluserhotel
			}).then(function (results) {
				
				if (results.status == "success") {
					
					//$scope.user.userhotels.splice($scope.user.userhotels.indexOf(Deluserhotel), 1);
					//$scope.totalItems = $scope.users.length;  
					Data.toast(results);
					Deluserhotel.ID=0;
				}
				else
				{
					Data.toast(results);
				}
			});
		
    };
	
	$scope.doDeleteUserWidget = function (Deluserwidget) {
		

			//alert(Deluser.ID);
			Data.post('DeleteUserWidget', {
				userwidget: Deluserwidget
			}).then(function (results) {
				
				if (results.status == "success") {
					 
					Data.toast(results);
					Deluserwidget.ID=0;
				}
				else
				{
					Data.toast(results);
				}
			});
		
    };
	
	$scope.doAddUserHotel = function (Adduserhotel) {
		

			//alert(Adduserhotel.ID);
			Data.post('AddUserHotel', {
				userhotel: Adduserhotel
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {
					
					//$scope.user.userhotels.splice($scope.user.userhotels.indexOf(Deluserhotel), 1);
					//$scope.totalItems = $scope.users.length;  
					Data.toast(results);
					//Adduserhotel.ID=0;
					//alert(results.uid);
					Adduserhotel.ID=results.uid;
				}
				else
				{
					Data.toast(results);
				}
			});
		
    };

    $scope.doChangeDefaultUserHotel = function (item) {
		

			//alert(Adduserhotel.ID);
			Data.post('ChangeDefaultUserHotel', {
				userhotel: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {
					
					//$scope.user.userhotels.splice($scope.user.userhotels.indexOf(Deluserhotel), 1);
					//$scope.totalItems = $scope.users.length;  
					Data.toast(results);
					//Adduserhotel.ID=0;
					//alert(results.uid);
					
				}
				else
				{
					Data.toast(results);
				}
			});
		
    };
	
	$scope.doAddUserWidget = function (Adduserwidget) {
			Data.post('AddUserWidget', {
				userwidget: Adduserwidget
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					Adduserwidget.ID=results.uid;
				}
				else
				{
					Data.toast(results);
				}
			});
		
    };
	
	$scope.doCancel = function () {
		$location.path('usermgmt');
	}
	
	$scope.doAddNewUser = function () {
		$location.path('usermgmt/view/0');
	}
	
	$scope.LoadAllUsers = function() 
	{
		
		if($routeParams.id==null)
		{
			$scope.FormType = 'LIST';
			$scope.IsUserListLoading = true;
			Data.Addtoast("info","Loading Users");
			Data.get('GetAllNonAdminUsers').then(function (results) {
				//alert(results.users);
				$scope.users = results.users;
				
				$scope.totalItems = $scope.users.length;  
				$scope.IsUserListLoading = false;
				//alert($scope.users.length);
				//thisObj.setMygrid();   
            });
			
		}
		else 
		{
			if($routeParams.id==0)
			{
				$scope.FormType = 'ADD';
				
				$scope.UserEditErrorMessage = "";
				$scope.isUserEditLoading = true;
				Data.Addtoast("info","Loading User Info");
				Data.get('GetAllTitlesForAddUser').then(function (results) {
					//alert(results.user);
					$scope.AllTitles = results.titles;
					
					//$scope.totalItems = $scope.users.length;  
					//alert($scope.users.length);
					//thisObj.setMygrid();   
					$scope.isUserEditLoading = false;
				});
			}
			else
			{
				$scope.FormType = 'EDIT';
		
		
			//alert($routeParams.id);
			$scope.UserEditErrorMessage = "";
			$scope.isUserEditLoading = true;
			Data.Addtoast("info","Loading User Info");
			//Data.get('GetUser?id='+$routeParams.id).then(function (results) {
			Data.post('GetUser',{
				dparams: {'ID':$routeParams.id}
			}).then(function (results) {
				//alert(results.user);
				if(!results.Error && results.user!=null && results.titles!=null)
					{
						//alert('came');
						$scope.user = results.user;
						$scope.AllTitles = results.titles;
						$scope.isUserEditLoading = false;
					}
				else
				{
					$scope.UserEditErrorMessage = "oops! An Error occured. We are retrying";
					$timeout( function(){  $scope.LoadAllUsers(); }, 3000);
					$scope.isUserEditLoading = false;
				}
				//$scope.totalItems = $scope.users.length;  
				//alert($scope.users.length);
				//thisObj.setMygrid();   
            });
			}
		}
				
	}
	$scope.LoadAllTitles = function()
	{
		if($routeParams.id==null)
		{
			$scope.Title = {"ID":"0","Name":""};
			$scope.TitleFormType = 'LIST';
			$scope.IsTitlesListLoading = true;
			Data.Addtoast("info","Loading Titles");
			Data.get('GetAllTitles').then(function (results) {
				//alert(results.Titles);
				$scope.titles = results.Titles;
				$scope.TitlestotalItems = $scope.titles.length;  
				$scope.IsTitlesListLoading = false;
				//alert($scope.users.length);
				//thisObj.setMygrid();   
            });
		}
	}
	


	

	$scope.LoadAllRolesToObservationStatus = function()
	  {
		  //alert('hai');
		  
		  Data.post('LoadAllRolesToObservationStatus',{
				dparams: {'RoleID':$scope.Role.ID}
			}).then(function (results) {
				//alert(results.Error);
				if(results.RolesToObservationStatusList!=null)
				{
					//alert(results.Data);
					$scope.ObservationStatusList = results.RolesToObservationStatusList;
					$scope.RolesToStatustotalItems = results.RolesToObservationStatusList.length;
					//$timeout( function(){ $scope.LoadLogActivity(); }, 3000);
					
				}
				
				
		  }); 
	  }
	
	$scope.DoSaveTitle = function (item)
	{
		Data.post('DoSaveTitle', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					item.ID=results.uid;
					$scope.LoadAllTitles();
				}
				else
				{
					Data.toast(results);
				}
			});
	}
	
	$scope.DoSaveRole = function (item)
	{
		Data.post('DoSaveRole', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					item.ID=results.uid;
					$scope.LoadAllRoles();
				}
				else
				{
					Data.toast(results);
				}
			});
	}

	$scope.DoSaveRoleToObservationsStatus = function (item)
	{
		Data.post('DoSaveRoleToObservationsStatus', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					item.ID=results.uid;
					$scope.LoadAllRolesToObservationStatus();
					$scope.CancelSaveRoleToObservationSttaus();
				}
				else
				{
					Data.toast(results);
				}
			});
	}

	$scope.DoDeleteRoleToObservationsStatus = function (item)
	{
		if(confirm('Do you really want to delete this status ?'))
		{
		Data.post('DoDeleteRoleToObservationsStatus', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					item.ID=results.uid;
					$scope.LoadAllRolesToObservationStatus();
				}
				else
				{
					Data.toast(results);
				}
			});
		}
	}
	
	$scope.DoSaveWidgetOrder = function (item)
	{
		Data.post('DoSaveWidgetOrder', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					//item.ID=results.uid;
					//$scope.LoadAllRoles();
				}
				else
				{
					Data.toast(results);
				}
			});
	}
	
	
	$scope.ShowEditRoleForm = function (item)
	{
		$scope.Role = item;
		$scope.RoleFormType = 'EDIT';
		$scope.ObservationStatusList = null;
		$scope.LoadAllRolesToObservationStatus();
	}

	$scope.ShowEditRoleToObservationStatusForm = function (item)
	{
		//$scope.Role = item;
		$scope.AddRoleToObservationStatusForm = null;
		$scope.AddRoleToObservationStatusForm = item;
		//alert($scope.AddRoleToObservationStatusForm.InDropdown);
		//alert($scope.AddRoleToObservationStatusForm.InView);
		//alert($scope.AddRoleToObservationStatusForm.CanEdit);
		$scope.RoleToObservationFormType = 'EDIT';
		//alert($scope.AddRoleToObservationStatusForm);
		//$scope.ObservationStatusList = null;
		//$scope.LoadAllRolesToObservationStatus();
	}
	
	$scope.ShowEditTitleRole = function (item)
	{
		$scope.IsTitlesListLoading = true;
		//alert(item);
		$scope.EditingTitleForRole = item;
		Data.post('GetAllRolesForTitle', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					//alert(results.AssignedRoles);
					//Data.toast(results);
					//item.ID=results.ID;
					$scope.EditingTitleForRole.AssignedRoles = results.AssignedRoles;
					//$scope.LoadAllRoles();
					$scope.TitleFormType = 'PERMISSION';
					$scope.IsTitlesListLoading = false;
				}
				else
				{
					Data.toast(results);
				}
			});
		
	}
	
	$scope.ShowEditRolePermission = function (item)
	{
			$scope.IsRolesListLoading = true;
		//alert(item);
		$scope.EditingRoleForPermission = item;
		Data.post('GetAllPermissionsForRole', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					//alert(results.AssignedRoles);
					//Data.toast(results);
					//item.ID=results.ID;
					$scope.EditingRoleForPermission.AssignedPermissions = results.AssignedPermissions;
					//$scope.LoadAllRoles();
					$scope.RoleFormType = 'PERMISSION';
					$scope.IsRolesListLoading = false;
				}
				else
				{
					Data.toast(results);
				}
			});
		
	}
	
	$scope.ArrangeWidgets = function (item)
	{
			$scope.IsRolesListLoading = true;
		//alert(item);
		$scope.EditingRoleForPermission = item;
		Data.post('GetAllWidgetsForRoleToOrder', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					//alert(results.AssignedRoles);
					//Data.toast(results);
					//item.ID=results.ID;
					$scope.EditingRoleForPermission.WidgetsOrder = results.WidgetsOrder;
					//$scope.LoadAllRoles();
					$scope.RoleFormType = 'ARRANGE';
					$scope.IsRolesListLoading = false;
				}
				else
				{
					Data.toast(results);
				}
			});
		
	}
	
	$scope.CancelSaveRole = function ()
	{
		$scope.Role = {"ID":"0","Name":""};
		$scope.RoleFormType = 'LIST';
	}
	$scope.CancelSaveRoleToObservationSttaus = function ()
	{
		
		$scope.RoleToObservationFormType = 'LIST';
	}
	
	$scope.ShowEditTitleForm = function (item)
	{
		$scope.Title = item;
		$scope.TitleFormType = 'EDIT';
	}
	
	$scope.CancelSaveTitle = function ()
	{
		$scope.Title = {"ID":"0","Name":""};
		$scope.TitleFormType = 'LIST';
	}
	
	$scope.DoSaveTitleToRole = function (item)
	{
		Data.post('DoSaveTitleToRole', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					item.ID=results.ID;
					//$scope.LoadAllRoles();
				}
				else
				{
					Data.toast(results);
				}
			});
	}
	
	$scope.DoSaveRoleToPermission = function (item)
	{
		Data.post('DoSaveRoleToPermission', {
				dparams: item
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					item.ID=results.ID;
					//$scope.LoadAllRoles();
				}
				else
				{
					Data.toast(results);
				}
			});
	}
	
	function  fnsetMygrid() {
		//alert('came');
		//thisObj.setMygrid();   
		//Data.Addtoast("info","Loaded Users");
	}
	

$scope.LoadAllRoles = function()
	{
		if($routeParams.id==null)
		{
			$scope.Role = {"ID":"0","Name":""};
			$scope.RoleFormType = 'LIST';
			$scope.IsRolesListLoading = true;
			Data.Addtoast("info","Loading Roles");
			Data.get('GetAllRoles').then(function (results) {
				//alert(results.Titles);
				$scope.roles = results.Roles;
				$scope.RolestotalItems = $scope.roles.length;  
				$scope.IsRolesListLoading = false;
				//alert($scope.users.length);
				//thisObj.setMygrid();   
				//$timeout( function(){ thisObj.calljqueryScripts(); }, 600);
				
            });
		}

		
	}

	$scope.SaveRoleAccessToContactFormMessages = function(item)
	{

			//$scope.IsMessageListLoading = true;
			//Data.Addtoast("info","Loading Messages");
			item.AccessToContactFormMessages = (item.AccessToContactFormMessages==1?0:1);
			Data.post('SaveRoleContactMessagePermission',{
				dparams: item }
				).then(function (results) {
					if(results.status=='success')
					{
						Data.toast(results);
						//thisObj.calljqueryScripts();
					}  
            });
		//}
	}

	$scope.GetToggleClass = function(val)
	{
		if(val==1)
			return "class='btn btn-xs btn-success active'";
		else
			return "class='btn btn-xs btn-default'";

	}

	$scope.GoTo = function(url)
	{
		//alert(url);
		$location.path(url);
	}

	$scope.LoadAllSettings = function()
	{
		if($routeParams.id==null)
		{
			$scope.IsSettingsLoading = true;
			Data.Addtoast("info","Loading Settings");
			Data.get('GetAllSettings').then(function (results) {
				//alert(results.Titles);
				$scope.Settings = results.Settings;
				
				$scope.IsSettingsLoading = false;
				//alert($scope.users.length);
				//thisObj.setMygrid();   
				//$timeout( function(){ thisObj.calljqueryScripts(); }, 600);
				
            });
		}

		
	}

	$scope.DoSaveSettings = function (settingsItem)
	{
		if(confirm("do you really want to save the changes to the settings ?"))
		{
			$scope.IsSettingsLoading = true;
		Data.post('DoSaveSettings', {
				dparams: settingsItem
			}).then(function (results) {
				//alert(results.status);
				if (results.status == "success") {

					Data.toast(results);
					$scope.IsSettingsLoading = false;
				}
				else
				{
					Data.toast(results);
				}
			});
		}
	}

	$scope.LoadAllUsers();
	$scope.LoadAllTitles();
	$scope.LoadAllRoles();
	$scope.LoadAllSettings();
	
	
});

