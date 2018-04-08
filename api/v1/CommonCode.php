<?php 


$app->get('/session', function() {
    $db = new DbHandler();
	
    $session = $db->getSession();
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];
	$response["isadmin"] = (isset($session['isadmin'])?$session['isadmin'] :'');
	$response["userWidgets"] = $session['userWidgets'];
	//$response["userHotels"] = $session['userHotels'];
	
    echoResponse(200, $session);
});


$app->get('/GetLoggedUserInfo', function() {
	
    $db = new DbHandler();
	$session = $db->getSession();
    $user = $db->getOneRecord("select ID,Username,Password,Email,Firstname, Lastname,CreatedDate, IsAdmin, Active,Mobile from Portal_Users where ID=".$session['uid']);
    if ($user != NULL) {

				
			$response['status'] = "success";
			$response['message'] = 'Logged in successfully.';
			$user['ID'] = $user['ID'];
			$user['Username'] = $user['Username'];
			$user['Password'] = $user['Password'];
			$user['ConfirmPassword'] = $user['Password'];
			$user['Email'] = $user['Email'];
			$user['Firstname'] = $user['Firstname'];
			$user['Lastname'] = $user['Lastname'];
			$user['IsAdmin'] = $user['IsAdmin'];
			$user['Active'] = $user['Active'];
			$user['Mobile'] = $user['Mobile'];
			$response['user'] = $user;
		
	}
	else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});

$app->get('/GetAllNonAdminUsers', function() {
	
    $db = new DbHandler();
	$session = $db->getSession();
	//$titles = $db->getRecords("select * from Portal_UserTitle ");
	//$response['titles']=$titles;
    $users = $db->getRecords("select U.ID,Username,Password,Email,Firstname, Lastname,CreatedDate, IsAdmin, Active,Mobile, T.Name Title, Notes, (case when U.Active=1 then 'YES' else 'NO' end) ActiveText from Portal_Users U
	
					left JOIN Portal_UserTitle T on (U.Title = T.ID)

		where IsAdmin <> 1
	
	");
    if ($users != NULL) {

		$response['status'] = "success";
		$response['message'] = 'Logged in successfully.';
		foreach ($users as $user) {
			
			$response['users'][] = $user;
		}
	}
	else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});

$app->get('/GetAllTitles', function() {
	
    $db = new DbHandler();
	$session = $db->getSession();
    $Titles = $db->getRecords("select * from Portal_UserTitle");
	$response['Titles'] = array();
    if ($Titles != NULL) {

		foreach($Titles as $Title)
		{
			$response['status'] = "success";
			$response['message'] = 'Logged in successfully.';
		
			// $Uroles = $db->getRecords("select R.ID RoleID, R.Name, ifnull(UR.ID,0) ID, (case when UR.ID is null then 0 else 1 end) Assigned , 
						// (case when UR.Active is null then 0 else 1 end) Active,
						// t.id as UserTitleID 
						// from 
						// Portal_Roles R 
						// left join 
						// Portal_UserTitleToRoles UR on (R.ID = UR.RoleID and UR.UserTitleID = ".$Title['ID'].") 
						// left join 
						// Portal_UserTitle t on (t.ID = ".$Title['ID'].")");
			// $Title['AssignedRoles'] = $Uroles;
		
			$response['Titles'][] = $Title;
		}
			//$response['Titles'] = $Titles;
		
	}
	else {
            $response['status'] = "error";
            $response['message'] = 'No titles found';
        }
    echoResponse(200, $response);
});


$app->post('/GetAllRolesForTitle', function() use ($app) {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());
    $response['status'] = "success";
	$response['message'] = 'Logged in successfully.';
			$Uroles = $db->getRecords("select R.ID RoleID, R.Name, ifnull(UR.ID,0) ID, (case when UR.ID is null then 0 else 1 end) Assigned , 
						UR.Active,
						t.id as UserTitleID 
						from 
						Portal_Roles R 
						left join 
						Portal_UserTitleToRoles UR on (R.ID = UR.RoleID and UR.UserTitleID = ".$r->dparams->ID.") 
						left join 
						Portal_UserTitle t on (t.ID = ".$r->dparams->ID.")");
			$response['AssignedRoles'] = $Uroles;
		
		
	
    echoResponse(200, $response);
});


$app->post('/GetAllPermissionsForRole', function() use ($app) {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());
    $response['status'] = "success";
	$response['message'] = 'Logged in successfully.';


	$UrolesParent = $db->getRecords("select R.ID PermissionID, R.Name, ifnull(UR.ID,0) ID, (case when UR.ID is null then 0 else 1 end) Assigned , 
						 UR.Active,
						t.id as RoleID ,
						0 Expanded
						from 
						Portal_Permissions R 
						
						left join 
						Portal_RolesToPermissions UR on (R.ID = UR.PermissionID and UR.RoleID = ".$r->dparams->ID.") 
						left join 
						Portal_Roles t on (t.ID = ".$r->dparams->ID.") where R.ParentID is null 
						order by R.ID");
			$ind =0;
			foreach ($UrolesParent as $p) {
				# code...
				//echo $p['ID']."<br>";
								$Uroles = $db->getRecords("select R.ID PermissionID, R.Name, ifnull(UR.ID,0) ID, (case when UR.ID is null then 0 else 1 end) Assigned , 
						 UR.Active,
						t.id as RoleID 
						from 
						Portal_Permissions R 
						left join 
						Portal_RolesToPermissions UR on (R.ID = UR.PermissionID and UR.RoleID = ".$r->dparams->ID.") 
						left join 
						Portal_Roles t on (t.ID = ".$r->dparams->ID.") where  R.ParentID = ".$p['PermissionID']."
						order by R.ID");

				$UrolesParent[$ind]['Child'] = $Uroles;
				$ind++;
			}
			
			$response['AssignedPermissions'] = $UrolesParent;
		
		
	
    echoResponse(200, $response);
});

$app->post('/GetAllWidgetsForRoleToOrder', function() use ($app) {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());
    $response['status'] = "success";
	$response['message'] = 'Logged in successfully.';
			$WidgetsOrder = $db->getRecords("select W.*,(case when R.ID is null then W.ID else R.WidgetOrder end) WidgetOrder  from Portal_WidgetsMaster W left join Portal_WidgetOrderToRoles R
			on (W.ID = R.WidgetMasterID and R.RoleID = ".$r->dparams->ID.")");
			$response['WidgetsOrder'] = $WidgetsOrder;
		
		
	
    echoResponse(200, $response);
});

$app->post('/LoadAllRolesToObservationStatus', function() use ($app) {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());
    $response['status'] = "success";
	$response['message'] = 'Logged in successfully.';
			$allstatus = $db->getRecords("Select R.*, S.Name  StatusName, R.RoleID rid from Portal_RolesToObservationStatus R JOIN 
			Portal_ObservationStatus S ON (R.ObservationStatusID = S.ID)  where R.RoleID = ".$r->dparams->RoleID);
			$status = array();
			foreach ($allstatus as $item ) {

				$sql = "Select * from Portal_ObservationStatus where ID=".$item['ObservationStatusID'] ." union all 
					Select * from Portal_ObservationStatus where ID not in (select ObservationStatusID from Portal_RolesToObservationStatus where RoleID=".$r->dparams->RoleID.")";
					//echo $sql;
				$drpstatus = $db->getRecords($sql);
				$item['StatusDrp'] = $drpstatus;
				$status[]=$item;
			}

			$response['RolesToObservationStatusList'] = $status;
		
		
	
    echoResponse(200, $response);
});

$app->get('/GetAllRoles', function() {
	
    $db = new DbHandler();
	$session = $db->getSession();
    $Roles = $db->getRecords("select * from Portal_Roles");
	$response['Roles'] = array();
    if ($Roles != NULL) {

		$response['status'] = "success";
		$response['message'] = 'Logged in successfully.';
		
			$response['Roles'] = $Roles;
		
	}
	else {
            $response['status'] = "error";
            $response['message'] = 'No Roles found';
        }
    echoResponse(200, $response);
});

$app->post('/GetUser', function() use ($app){
	
	//$id = $_GET['id'];

    $db = new DbHandler();
	$session = $db->getSession();
	$titles = $db->getRecords("select * from Portal_UserTitle ");
	$response['titles']=$titles;
	$r = json_decode($app->request->getBody());
	$id = $r->dparams->ID;
    $users = $db->getRecords("select ID,Username,Password,Email,Firstname, Lastname,CreatedDate, IsAdmin, Active,Mobile, Title, Notes from Portal_Users where ID=$id");
    if ($users != NULL) {

		$response['status'] = "success";
		$response['message'] = 'Logged in successfully.';
		foreach ($users as $user) {
			
				
			
			$user['ID'] = $user['ID'];
			$user['Username'] = $user['Username'];
			$user['Password'] = $user['Password'];
			$user['ConfirmPassword'] = $user['Password'];
			$user['Email'] = $user['Email'];
			$user['Firstname'] = $user['Firstname'];
			$user['Lastname'] = $user['Lastname'];
			$user['IsAdmin'] = $user['IsAdmin'];
			$user['Active'] = ($user['Active']==1);
			$user['Mobile'] = $user['Mobile'];
			$response['user'] = $user;
			$response['user']['userhotels'] = null;
			$response['user']['userWidgets'] = null;
			
			$userHotels = $db->getRecords("select ifnull(P.ID,0) ID ,ifnull(P.UserID,$id) UserID, ifnull(P.HotelID, C.GroupID) HotelID, C.Name HotelName , P.DefaultSelection, P.CurrentlyBrowsing from (select distinct Name, GroupId from creat072_vue.channel where parentid=1) C
											left  JOIN ( select * from Portal_UserToHotels where UserID=$id) P ON (P.HotelID=C.GroupID) ");
			if ($userHotels != NULL) {
				foreach ($userHotels as $userHotel) {
					
					$response['user']['userhotels'][] = $userHotel;
				}
			}
			
			$userWidgets = $db->getRecords("select ifnull(U.ID,0) ID , W.ID WidgetID, ifnull(U.UserID,$id) UserID,  W.Name  from   Portal_Widgets W
											left  JOIN Portal_UserToWidgets  U  ON ( W.ID = U.WidgetID AND U.UserID=$id)  ");
			if ($userWidgets != NULL) {
				foreach ($userWidgets as $userWidget) {
					
					$response['user']['userWidgets'][] = $userWidget;
				}
			}
		}
	}
	else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});

$app->get('/GetAllTitlesForAddUser', function() {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$titles = $db->getRecords("select * from Portal_UserTitle ");
	$response['titles']=$titles;
    echoResponse(200, $response);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
    $password = $r->customer->password;
    $email = $r->customer->email;
    $user = $db->getOneRecord("select ID,Username,Password,Email,Firstname, Lastname,CreatedDate, IsAdmin, Active from Portal_Users where Username='$email' and Active=1");
    if ($user != NULL) {
        //if(passwordHash::check_password($user['password'],$password)){
    	//if($user['Password']==$password && strcmp($user['Username'], $email)==0) // make username also case sensitive

		if($user['Password']==$password)
		{
			$sqlRoles = "select distinct P.Name from Portal_Users U 
					JOIN Portal_UserTitle UT 
					on (U.Title = UT.ID)
					JOIN Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID)
					JOIN Portal_Roles R
					on (UR.RoleID = R.ID)
					JOIN Portal_RolesToPermissions RP
					on (RP.RoleID = R.ID)
					JOIN Portal_Permissions P
					on (P.ID = RP.PermissionID)
					where U.ID = ".$user['ID']." and P.Name='Login'	and RP.Active=1";
		
			$UserPermissions = $db->getRecords($sqlRoles);
			if($UserPermissions != NULL || $user['IsAdmin']=="1")
			{
				$response['status'] = "success";
				$response['message'] = 'Logged in successfully.';
				$response['name'] = $user['Firstname'];
				$response['uid'] = $user['ID'];
				$response['email'] = $user['Email'];
				$response['createdAt'] = $user['CreatedDate'];
				if (!isset($_SESSION)) {
					session_start();
				}
				$_SESSION['uid'] = $user['ID'];
				$_SESSION['email'] = $user['Email'];
				$_SESSION['name'] = $user['Firstname'];
				$_SESSION['isadmin'] = $user['IsAdmin'];
				$_SESSION['userWidgets'] = null;
				//$_SESSION['userHotels'] = null;
				
				//$db->writeLog($user['ID'],'Logged in',NULL, 'Login');
				
				if(isset($_SESSION['uid']))
				{
					$userWidgets = $db->getRecords("select * from  Portal_UserToWidgets P JOIN Portal_Widgets W on (P.WidgetID=W.ID) where P.UserID=".$user['ID']."  ");
						if ($userWidgets != NULL) {
							foreach ($userWidgets as $userWidget) {
								
								$_SESSION['userWidgets'][] = $userWidget;
							}
						}
				}
			}
			else {
            $response['status'] = "error";
            $response['message'] = 'Login denied.';
			}
			/* if(isset($_SESSION['uid']))
			{
				$userHotels = $db->getRecords("select C.* from 
												(select distinct Name, GroupId from creat072_vue.channel where parentid=1) C
												 JOIN ( select * from Portal_UserToHotels where UserID=".$user['ID'].") P ON (P.HotelID=C.GroupID) ");
				if ($userHotels != NULL) {
					foreach ($userHotels as $userHotel) {
						
						$_SESSION['userHotels'][] = $userHotel;
					}
				}
			} */
			
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});
$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'password'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $phone = $r->customer->phone;
    $name = $r->customer->name;
    $email = $r->customer->email;
    $address = $r->customer->address;
    $password = $r->customer->password;
    $isUserExists = $db->getOneRecord("select 1 from customers_auth where phone='$phone' or email='$email'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
        $tabble_name = "customers_auth";
        $column_names = array('phone', 'name', 'email', 'password', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});

$app->post('/updateuseractivestatus', function() use ($app) {
    //require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	
    $sql = "Update Portal_Users set ";
	$sql .= "Active = '".$r->user->Active."' ";
	//$sql .= " where ID = '".$session['uid']."' ";
	$sql .= " where ID = '".$r->user->ID."' ";
	
        $result = $db->executeSQL($sql);
        if ($result != NULL) {
        	
        	$logtext = "";
        	if($r->user->Active==1)
        		$logtext = "Enabled the user with Username :".$r->user->Username;
        	if($r->user->Active==0)
        		$logtext = "Disabled the user with Username :".$r->user->Username;

        	$db->writeLog($session['uid'],$logtext,$_SESSION['HotelID'],'HotelSettings_Contacts');

            $response["status"] = "success";
            $response["message"] = "user updated successfully";
			
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to update your profile. Please try again";
            
        }            
    echoResponse(200, $response);
	
});

$app->post('/ResetUserPassword', function() use ($app) {
    //require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	
    $sql = "Update Portal_Users set ";
	$sql .= "Password = '".$r->user->resetpwd1."' ";
	//$sql .= " where ID = '".$session['uid']."' ";
	$sql .= " where ID = '".$r->user->ID."' ";
	
        $result = $db->executeSQL($sql);
        if ($result != NULL) {
        	
        	$logtext = "";
        	
        		$logtext = "Password reset done for user with Username :".$r->user->Username;


        	$db->writeLog($session['uid'],$logtext,$_SESSION['HotelID'],'HotelSettings_Contacts');

            $response["status"] = "success";
            $response["message"] = "Password Reset Done.";
			
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to rest password. Please try again";
            
        }            
    echoResponse(200, $response);
	
});

$app->post('/updateprofile', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	
    $sql = "Update Portal_Users set ";
	$sql .= "Email = '".$r->user->Email."' , ";
	$sql .= "Password = '".$r->user->Password."' ,";
	$sql .= "Firstname = '".$r->user->Firstname."' ,";
	$sql .= "Lastname = '".$r->user->Lastname."' ,";
	$sql .= "Mobile = '".$r->user->Mobile."' ,";
	if(isset($r->user->Title))
	$sql .= "Title = '".$r->user->Title."' ,";

	if(isset($r->user->Notes))
	$sql .= "Notes = '".$r->user->Notes."' ,";

	$sql .= "Active = '".$r->user->Active."' ";
	//$sql .= " where ID = '".$session['uid']."' ";
	$sql .= " where ID = '".$r->user->ID."' ";
	
        $result = $db->executeSQL($sql);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "Profile updated successfully";
			if($session['uid']==$r->user->ID)
			{
				$_SESSION['email'] = $r->user->Email;
				$_SESSION['name'] = $r->user->Firstname;
			}
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to update your profile. Please try again";
            
        }            
    echoResponse(200, $response);
	
});


$app->post('/AddNewUser', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	//print_r($r);
	$isUserExists = $db->getOneRecord("select 1 from Portal_Users where Username='".$r->user->Username."' ");
    if(!$isUserExists){
			$sql = "Insert into Portal_Users (Email, Username, Password,Firstname, Lastname, Mobile, Active, IsAdmin )  values ( ";
			$sql .= "'".$r->user->Email."' , ";
			$sql .= "'".$r->user->Password."' ,";
			$sql .= "'".$r->user->Firstname."' ,";
			$sql .= "'".$r->user->Lastname."' ,";
			$sql .= "'".$r->user->Mobile."' ";
			$sql .= "'".$r->user->Active."' ";
			$sql .= "'".$r->user->IsAdmin."' )";
			//$sql .= " where ID = '".$r->user->ID."' ";
			
			//$r->customer->password = passwordHash::hash($password);
        $tabble_name = "Portal_Users";
        $column_names = array('Email', 'Username', 'Password','Firstname', 'Lastname', 'Mobile','Title','Notes', 'Active', 'IsAdmin');
        $result = $db->insertIntoTable($r->user, $column_names, $tabble_name);
		if ($result != NULL) {
				if($r->user->From=='Dashboard')
				{
					if($r->user->AssignedHotel!=null && $r->user->AssignedHotel!=="")
					{
						$result1 = $db->executeSQL("Insert into Portal_UserToHotels (UserID, HotelID) values ($result,".$r->user->AssignedHotel.")");
						//$sql="Select U.* from Portal_Users U join Portal_UserToHotels H on (U.ID = H.UserID) where U.IsAdmin=0 AND U.Active=1 AND H.HotelID=".$r->user->AssignedHotel;
					
			
						$sql="Select *, concat(U.Firstname,' ',U.Lastname) NameOfUser, T.Name TitleName from 
						 Portal_Users U JOIN Portal_UserTitle T on (U.Title=T.ID) JOIN  Portal_UserToHotels UH ON (UH.UserID =  U.ID)
						where U.ID not in (1,17,24,87,113) and UH.HotelID=".$r->user->AssignedHotel ;

						$HotelUserDetails = $db->getRecords($sql);
						$HotelUserDetailsdatarows = array();

						if ($HotelUserDetails != NULL) {

							foreach ($HotelUserDetails as $HotelUserDetail) {

								$othersql="Select 
									c.GroupId HotelID, c.Name HotelName
									
									from 
								 Portal_Users U JOIN  Portal_UserToHotels UH ON (UH.UserID =  U.ID)
                                 JOIN creat072_vue.channel c on (c.GroupId = UH.HotelID)
								where U.ID = ".$HotelUserDetail['UserID'];

								$associatedHotels = $db->getRecords($othersql);
								$HotelUserDetail['associatedHotels'] = $associatedHotels ;
								$HotelUserDetailsdatarows[] = $HotelUserDetail;
							}

						}
						
						$response['HotelUsers'] = $HotelUserDetailsdatarows;
						
						
					}
				}
					$response["status"] = "success";
					$response["message"] = "A new user is added successfully";
					$response["uid"] = $result;
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update your profile. Please try again";
					
				}            
			echoResponse(200, $response);
	}else{
        $response["status"] = "error";
        $response["message"] = "An user with the same username already exists!";
        echoResponse(201, $response);
    }
});


$app->post('/DeleteUser', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
	
		$sql = "delete from Portal_UserToHotels  ";

		$sql .= " where UserID = '".$r->user->ID."' ";
	
        $result = $db->executeSQL($sql);
		
		$sql = "delete from Portal_HotelContacts  ";

		$sql .= " where UserID = '".$r->user->ID."' ";
	
        $result = $db->executeSQL($sql);
		
		$sql = "delete from Portal_Users  ";

		$sql .= " where ID = '".$r->user->ID."' ";
	
        $result = $db->executeSQL($sql);

		if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "User deleted successfully.";
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to delete the user. Please try again";
					
				}            
			echoResponse(200, $response);
	
});

$app->post('/doDeleteRoleToObservationStatus', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
	
		$sql = "delete from Portal_RolesToObservationStatus  ";

		$sql .= " where ID = '".$r->item->ID."' ";
	
        $result = $db->executeSQL($sql);
		
		

		if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Status deleted successfully.";
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to delete the Status. Please try again";
					
				}            
			echoResponse(200, $response);
	
});

$app->post('/DeleteUserHotel', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
	
		$sql = "delete from Portal_UserToHotels  ";

		$sql .= " where ID = '".$r->userhotel->ID."' ";
	
        $result = $db->executeSQL($sql);

		if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "User Hotel deleted successfully.";
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to delete the user hotel. Please try again";
					
				}            
			echoResponse(200, $response);
	
});

$app->post('/DeleteUserWidget', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
	
		$sql = "delete from Portal_UserToWidgets  ";

		$sql .= " where ID = '".$r->userwidget->ID."' ";
	
        $result = $db->executeSQL($sql);

		if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "User Hotel deleted successfully.";
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to delete the user hotel. Please try again";
					
				}            
			echoResponse(200, $response);
	
});

$app->post('/AddUserHotel', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
		$tabble_name = "Portal_UserToHotels";
        $column_names = array('UserID', 'HotelID');
        $result = $db->insertIntoTable($r->userhotel, $column_names, $tabble_name);
		if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "User is successfuly assigned to ".$r->userhotel->HotelName;
					$response["uid"] = $result;
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update your profile. Please try again";
					
				}            
			echoResponse(200, $response);
	
});

$app->post('/ChangeDefaultUserHotel', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
		$sql = "update Portal_UserToHotels set DefaultSelection=0 where  UserID= ".$r->userhotel->UserID;
		$result = $db->executeSQL($sql);
		$sql = "update Portal_UserToHotels set DefaultSelection=1 where  ID= ".$r->userhotel->ID;
		$result = $db->executeSQL($sql);
        
		if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Default Hotel Updated";
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update Default Hotel";
					
				}            
			echoResponse(200, $response);
	
});

$app->post('/AddUserWidget', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
		$tabble_name = "Portal_UserToWidgets";
        $column_names = array('UserID', 'WidgetID');
        $result = $db->insertIntoTable($r->userwidget, $column_names, $tabble_name);
		if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "User is successfuly assigned to ".$r->userwidget->Name;
					$response["uid"] = $result;
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to assign widget to user. Please try again";
					
				}            
			echoResponse(200, $response);
	
});


$app->get('/logout', function() {
    $db = new DbHandler();
	$session = $db->getSession();
	$db->writeLog($session['uid'],'Logged out');
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});

$app->get('/mddata', function() use ($app)  {
    
    $request = $app->request();
	$db = new DbHandler();
	$session = $db->getSession();
	$results  = "";
	//var_dump($request->get('ip'));
    //$response["Data"] = "[{'id':'1','username':'lucentx','first_name':'Aron','last_name':'Barbosa','address':'Manila, Philippines'},{'id':'2','username':'ozzy','first_name':'Ozzy','last_name':'Osbourne','address':'England'},{'id':'3','username':'tony','first_name':'Tony','last_name':'Iommi','address':'England'}]";
	//$sql = "select * FROM users ORDER BY id";
  try {
    $sqsl = "select * from mddata where hotel='".$session['email']."'";
	//echo $sqsl;
    $results['Data'] = $db->getRecords($sqsl);
	
    //$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
    //$db = null;
    //$response['Data']= json_encode($wines);
  } catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}'; 
  }
    
    echoResponse(200, ($results));
});

$app->get('/sampleHightChartData', function() use ($app)  {
    
    $results['Data'] = "{
				chart: {
					renderTo: 'HighCharData',
					type: 'column'
				},
				title: {
					text: 'Stacked column chart'
				},
				xAxis: {
					categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Total fruit consumption'
					},
					stackLabels: {
						enabled: true,
						style: {
							fontWeight: 'bold',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
						}
					}
				},
				legend: {
					align: 'right',
					x: -30,
					verticalAlign: 'top',
					y: 25,
					floating: true,
					backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
					borderColor: '#CCC',
					borderWidth: 1,
					shadow: false
				},
				tooltip: {
					headerFormat: '<b>{point.x}</b><br/>',
					pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
				},
				plotOptions: {
					column: {
						stacking: 'normal',
						dataLabels: {
							enabled: true,
							color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
							style: {
								textShadow: '0 0 3px black'
							}
						}
					}
				},
				series: [{
					name: 'John',
					data: [5, 3, 4, 7, 2]
				}, {
					name: 'Jane',
					data: [2, 2, 3, 2, 1]
				}, {
					name: 'Joe',
					data: [3, 4, 4, 2, 5]
				}]
			}";
    
    echoResponse(200, ($results));
	//echo $results;
});

/* $app->get('/GetHotelMenu', function() use ($app)  {
    
    $results['Data'] = "<ul class='nav site-nav'>
    <li class=flyout>
    
        <a href=#>Awesome Hotels</a>
        
        <!-- Flyout -->
        <ul class='flyout-content nav stacked'>
           <li><a><input style='zoom:1.5; ' type='checkbox' id='chk10' disabled  />&nbsp;Foo Bar</a></li>
            <li><a>Bar Baz</a></li>
            
        </ul>
    
    </li>

</ul>

";
    
    echoResponse(200, ($results));
	//echo $results;
}); */

$app->get('/GetHotelMenu', function()  {
    
    
	
    $db = new DbHandler();
	$session = $db->getSession();
	if($session['isadmin']=="1")
	{
		$sql = "select *, '+' CollapseLabel, 0 isChecked from creat072_vue.channel ";
	}
	else
	{
		$sql = "select *, '+' CollapseLabel, 0 isChecked from creat072_vue.channel where parentid=0
						union
						select c.*, '+' CollapseLabel, 0 isChecked 
						from creat072_vue.channel c
						join Portal_UserToHotels n
						on (c.groupid=n.HotelID) 
						where parentid=1
						and n.UserID=".$session['uid']."
						union
						select *, '+' CollapseLabel, 0 isChecked from 
							creat072_vue.channel where ParentId>1;";
	}
    $hotels = $db->getRecords($sql);
    if ($hotels != NULL) {

		$response['status'] = "success";
		$response['message'] = 'Logged in successfully.';
		$menuitems = array();
		foreach ($hotels as $hotel) {
			
				
			
			$menuitems[] = $hotel;
			
			
		}
		
		$response['data'] = $db->buildtree($menuitems);
	}
	else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});


$app->post('/UpdateCurrentlyBrowsingHotel', function() use ($app)  
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	$userid = $session['uid'];
	$db->executeSQL("Update Portal_UserToHotels set CurrentlyBrowsing=0 where UserID=$userid");
	$db->executeSQL("Update Portal_UserToHotels set CurrentlyBrowsing=1 where UserID=$userid and HotelID=".$r->dparams->SelectedHotel);

	$_SESSION['HotelID'] = $r->dparams->SelectedHotel;
	$db->writeLog($session['uid'],'Logged in 1',$r->dparams->SelectedHotel,'Login');
});

$app->get('/LoadDashboardConfigs', function()   
{
	 
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
		if($session['isadmin']=="1")
		{
			$sql = " select *, '+' CollapseLabel, 0 isChecked, (case when I.red is not null and I.red=1 then 'red' else 'white' end) color , 0 CurrentlyBrowsing, 0 DefaultSelection from creat072_vue.channel c
				left join (select distinct hotelid , red from portal_InvalidFunctionalGroups) I
							on (c.GroupId = I.hotelid)
							where Parentid<=1 ";
		}
		else
		{
			$sql = " select *, '+' CollapseLabel, 0 isChecked, 'white' color, 0 CurrentlyBrowsing, 0 DefaultSelection  from creat072_vue.channel where parentid=0
							union
							select c.*, '+' CollapseLabel, 0 isChecked , (case when I.red is not null and I.red=1   then 'red' else 'white' end) color , ifnull(CurrentlyBrowsing,0) CurrentlyBrowsing, ifnull(DefaultSelection,0) DefaultSelection
							from creat072_vue.channel c
							join creat072_vue.Portal_UserToHotels n
							on (c.groupid=n.HotelID) 
							left join (select distinct hotelid , red from portal_InvalidFunctionalGroups) I
							on (n.HotelID = I.hotelid)
							where parentid=1
							and n.UserID=".$session['uid']."
							";
		}
		$response['SelectedHotel'] = null;
		$firstHotelSelected= 0;
		$hotels = $db->getRecords($sql);
		if ($hotels != NULL) {

			$channel['status'] = "success";
			$channel['message'] = 'Logged in successfully.';
			$menuitems = array();
			$menuitems1 = array();
			//print_r($hotels);
			//die();
			$selectedLoginHotel = null;
			foreach ($hotels as $hotel) {
				
				if($hotel['GroupId']>1 && $firstHotelSelected==0)
				{
					
					if($hotel['CurrentlyBrowsing']==1)
					{
						//echo "1";
						$firstHotelSelected =1;
						$hotel['isChecked']=1;
					//$response['SelectedHotel'] = $hotel['GroupId'];
						$response['SelectedHotel'] = $hotel;
						$selectedLoginHotel = $hotel;
						//$db->writeLog($session['uid'],'Logged in 2',$hotel['GroupId'],'Login');
					}
				}

				 if($hotel['GroupId']>1 && $firstHotelSelected==0)
				{
					
					if($hotel['DefaultSelection']==1)
					{
						//echo "2";
						$firstHotelSelected =1;
						$hotel['isChecked']=1;
					//$response['SelectedHotel'] = $hotel['GroupId'];
						$response['SelectedHotel'] = $hotel;
						$selectedLoginHotel = $hotel;
						//$db->writeLog($session['uid'],'Logged in 3',$hotel['GroupId'],'Login');
					}
				}
				
				
				
				$hotel['isChecked'] = ($hotel['isChecked']=="1" ? true:false);
				
				$menuitems[] = $hotel;
			}

			if($firstHotelSelected==0)
			{
				foreach ($menuitems as $hotel)
				{
					 if($hotel['GroupId']>1 && $firstHotelSelected==0)
					{
						//echo "3";
						$firstHotelSelected =1;
						$hotel['isChecked']=true;
						//$response['SelectedHotel'] = $hotel['GroupId'];
						$response['SelectedHotel'] = $hotel;
						$selectedLoginHotel = $hotel;
						//$db->writeLog($session['uid'],'Logged in 4',$hotel['GroupId'],'Login');
					}
					$menuitems1[] = $hotel;
				}
			}
			else
			{
				$menuitems1 = $menuitems;
			}

			if($selectedLoginHotel != null)
			{
				//$db->executeSQL("Update Portal_UserToHotels set CurrentlyBrowsing=1 where UserID=".$session['uid']." and HotelID=".$selectedLoginHotel['GroupId']);
				//echo "Update Portal_UserToHotels set CurrentlyBrowsing=0 where UserID=".$selectedLoginHotel['GroupId']."<br>";
				//echo "Update Portal_UserToHotels set CurrentlyBrowsing=1 where UserID=".$session['uid']." and HotelID=".$selectedLoginHotel['GroupId'];
				$db->executeSQL("Update Portal_UserToHotels set CurrentlyBrowsing=0 where UserID=".$selectedLoginHotel['GroupId']);
				$db->executeSQL("Update Portal_UserToHotels set CurrentlyBrowsing=1 where UserID=".$session['uid']." and HotelID=".$selectedLoginHotel['GroupId']);
				$_SESSION['HotelID'] = $selectedLoginHotel['GroupId'];
				//die();
			}
			//print_r($menuitems);
			//die();
			//foreach ($menuitems as $hotel) {

			//	if($hotel['isChecked'])
			//	$db->executeSQL("Update Portal_UserToHotels set CurrentlyBrowsing=1 where HotelID=".$hotel['GroupId']." and UserID=".$session['uid']."");

			//}
			
			$channel['data'] = $db->buildtree($menuitems1);
		}
		else {
				$channel['status'] = "error";
				$channel['message'] = 'No such user is registered';
			}
			
			
			$response['channels']= $channel;
			if($session['isadmin']==1)
			{
				$sql = "select Name, 1 Active from Portal_Permissions";
			}
			else
			{
				$sql = "select distinct P.Name, ifnull(RP.Active,0) Active from Portal_Users U 
					JOIN Portal_UserTitle UT 
					on (U.Title = UT.ID and U.ID = ".$session['uid'].")
					JOIN Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID and UR.Active=1)
					JOIN Portal_Roles R
					on (UR.RoleID = R.ID)
					JOIN Portal_RolesToPermissions RP
					on (RP.RoleID = R.ID)
					right JOIN Portal_Permissions P
					on (P.ID = RP.PermissionID)
					
							";
			}
		
			$UserPermissions = $db->getRecords($sql);
			$response["userPermissions"]= $UserPermissions;
			
			if($session['isadmin']==1)
			{
				$GetAllWidgets = $db->getRecords("SELECT * FROM creat072_vue.Portal_WidgetsMaster");
			}
			else
			{
				$role = $db->getOneRecord("select RoleID from Portal_Users U
				join Portal_UserTitleToRoles UT on (UT.UserTitleID=U.Title)	where U.ID=".$session['uid']);
				
				$GetAllWidgets = $db->getRecords("SELECT W.* FROM creat072_vue.Portal_WidgetsMaster W 
				left join Portal_WidgetOrderToRoles O
				on (W.ID = O.WidgetMasterID and O.RoleID in (".$role['RoleID']."))
				 
				order by (case when O.WidgetOrder is not null then O.WidgetOrder else W.ID end)");
			}
			
			$response["AllWidgetsList"]= $GetAllWidgets;
	}
	
	{// Load userWidgets
		
		$response["isadmin"] = ($session['isadmin']==1?true:false);
		//$response["LoggedUserName"] = $session['name'];
		$response["userWidgets"] = $session['userWidgets'];
	}
	
	
	
	
	$response['data']=$response;
	
    echoResponse(200, $response);
});

$app->post('/LoadWeather', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	
	
	{ // Load weather
		
		//order by n.Name , date desc

		if($session['isadmin']=="1")
		{
			$sql = "		select date_format(date, '%Y-%m-%d') date,date_format(date, '%d-%m') date1, temp, hdd, cdd, n.Name
							from weather c
							join (select groupid, Name from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") n
							on (n.groupid = c.groupid)
							where 
							  c.date between '".$r->dparams->WeatherStartDate."' and '".$r->dparams->WeatherEndDate."'
							 order by  date desc
							";
		}
		else
		{
		
			$sql = "		select date_format(date, '%Y-%m-%d') date, date_format(date, '%d-%m') date1,temp, hdd, cdd, n.Name
							from weather c
							join creat072_vue.Portal_UserToHotels n
							on (c.groupid=n.HotelID) 
							join (select groupid, Name from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") n
							on (n.groupid = c.groupid)
							where 
							 n.UserID=".$session['uid']." and c.date between '".$r->dparams->WeatherStartDate."' and '".$r->dparams->WeatherEndDate."'
							 order by  date desc
							";
		}
		//echo $sql;
		$weatherDetails = $db->getRecords($sql);
		$menuitems = array();
			$chartCategory =   array();
			$seriesCategory =   array();
		if ($weatherDetails != NULL) {

			$weather['status'] = "success";
			$weather['message'] = 'Logged in successfully.';
			
			foreach ($weatherDetails as $weatherDetail) {
				$menuitems[] = $weatherDetail;
			}
			
			foreach (array_reverse($weatherDetails) as $weatherDetail) {
				if(!in_array("'".$weatherDetail['date1']."'", $chartCategory))
				$chartCategory[]="'".$weatherDetail['date1']."'";
			
				//array_key_exists($weatherDetail['Name'].'_hdd', $seriesCategory)
				//$seriesCategory[$weatherDetail['Name'].'_hdd'] = (!array_key_exists($weatherDetail['Name'].'_hdd', $seriesCategory)?'':$seriesCategory[$weatherDetail['Name'].'_hdd']).$weatherDetail['hdd'].",";
				//$seriesCategory[$weatherDetail['Name'].'_cdd'] = (!array_key_exists($weatherDetail['Name'].'_cdd', $seriesCategory)?'':$seriesCategory[$weatherDetail['Name'].'_cdd']).$weatherDetail['cdd'].",";
				//$seriesCategory[$weatherDetail['Name'].'_temp'] = (!array_key_exists($weatherDetail['Name'].'_temp', $seriesCategory)?'':$seriesCategory[$weatherDetail['Name'].'_temp']).$weatherDetail['temp'].",";
				
				$seriesCategory['hdd'] = (!array_key_exists('hdd', $seriesCategory)?'':$seriesCategory['hdd']).$weatherDetail['hdd'].",";
				
				$seriesCategory['temp'] = (!array_key_exists('temp', $seriesCategory)?'':$seriesCategory['temp']).$weatherDetail['temp'].",";
                $seriesCategory['cdd'] = (!array_key_exists('cdd', $seriesCategory)?'':$seriesCategory['cdd']).$weatherDetail['cdd'].",";
				
				
				
				
			}
			
			
			$weather['data'] = $menuitems;
			//print_r($chartCategory);

			//print_r($seriesCategory);
			//die();
		}
		else {
				$weather['status'] = "error";
				$weather['message'] = 'No Weather Information found ';
			}
			
			
			//$response['weather']= $weather;
	}
	
	{
		$lineChartText = "{
						chart: {
							renderTo: 'WeatherChart',
							type: 'line'
						},
						
						title: {
							text: 'Weather Information'
						},
						subtitle: {
							text: 'Source: https://www.wunderground.com/'
						},
						xAxis: {
							labels: {
									/*rotation: -45,*/
									style: {
										fontSize: '13px',
										fontFamily: 'Verdana, sans-serif'
									}
								},
							categories: [".implode(",",$chartCategory)."]
						},
						yAxis: {
							title: {
								text: 'Temp, HDD, CDD'
							}
						},
						plotOptions: {
							line: {
								dataLabels: {
									enabled: true
								},
								enableMouseTracking: false
							}
						},";
		
		$lineChartText.="series: [";
		$seriesstring = "";
		foreach($seriesCategory as $x => $x_value) {
                     $color = "color:'#FF6666'";
					 $legendName = "";
                     if($x=="temp")
                         $color = "color:'black'";
                     if($x=="cdd")
                         $color = "color:'#A4D3EE'";
					 
					 if($x=="temp")
						 $legendName = "Average Temperature";
					 if($x=="hdd")
						 $legendName = "Heating required";
					 if($x=="cdd")
						 $legendName = "Cooling required";
					 
			$seriesstring.="{name: '".$legendName."',$color, data: [".rtrim($x_value, ',')."]},";
		}
		$seriesstring = rtrim($seriesstring, ',');
		$lineChartText.=$seriesstring;
		$lineChartText.="]}";
				
			//echo $lineChartText;
			//die();		
        
				$weather['Linechart']= $lineChartText;
				
				$response['weather']= $weather;
				
	}
	
	
    echoResponse(200, $response);
});

$app->post('/LoadOccupancy', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	//print_r($r->dparams);
	//echo $r->dparams->WeatherEndDate;
	//echo $r->dparams->WeatherStartDate;
	//die();

	{ // Load weather
		
		if($session['isadmin']=="1")
		{
			$sql = "		select pk, date_format(date, '%Y-%m-%d') date, date_format(date, '%d-%m') date1,covers, rooms, functions, delegates, spa, sleepers, hotel, hotelid
							from mddailynewHO c
							
							where 
							  c.date between '".$r->dparams->OccupancyStartDate."' and '".$r->dparams->OccupancyEndDate."' and  hotelid = ".$r->dparams->SelectedHotel." 
							 order by hotel, date desc
							";
		}
		else
		{
		
			$sql = "		select c.pk, date_format(date, '%Y-%m-%d') date, date_format(date, '%d-%m') date1,covers, rooms, functions, delegates, spa, sleepers, hotel, c.hotelid
							from mddailynewHO c
							join Portal_UserToHotels n
							on (c.hotelid=n.HotelID)
							where 
							n.UserID=".$session['uid']." and  c.date between '".$r->dparams->OccupancyStartDate."' and '".$r->dparams->OccupancyEndDate."' 
							and c.hotelid = ".$r->dparams->SelectedHotel." 
							 order by hotel , date  desc
							";
		}
		//echo $sql;
		$OccupancyDetails = $db->getRecords($sql);
		$Occupancyitems = array();
		$chartCategory =   array();
		$seriesCategory =   array();
			
		$Occupancy['status'] = "success";
		$Occupancy['message'] = 'Logged in successfully.';
		$Occupancy['data'] = array();
			
		if ($OccupancyDetails != NULL) {

			$Occupancy['status'] = "success";
			$Occupancy['message'] = 'Logged in successfully.';
			
			foreach ($OccupancyDetails as $OccupancyDetail) {
				
			
				$Occupancyitems[] = $OccupancyDetail;
			}
			
			foreach (array_reverse($OccupancyDetails) as $OccupancyDetail) {
				
				if(!in_array("'".$OccupancyDetail['date1']."'", $chartCategory))
				$chartCategory[]="'".$OccupancyDetail['date1']."'";
			
				//array_key_exists($weatherDetail['Name'].'_hdd', $seriesCategory)
				$seriesCategory['Covers'] = (!array_key_exists('Covers', $seriesCategory)?'':$seriesCategory['Covers']).$OccupancyDetail['covers'].",";
				$seriesCategory['Sleepers'] = (!array_key_exists('Sleepers', $seriesCategory)?'':$seriesCategory['Sleepers']).$OccupancyDetail['sleepers'].",";
				$seriesCategory['Functions'] = (!array_key_exists('Functions', $seriesCategory)?'':$seriesCategory['Functions']).$OccupancyDetail['functions'].",";
				$seriesCategory['Delegates'] = (!array_key_exists('Delegates', $seriesCategory)?'':$seriesCategory['Delegates']).$OccupancyDetail['delegates'].",";
				$seriesCategory['Spa'] = (!array_key_exists('Spa', $seriesCategory)?'':$seriesCategory['Spa']).$OccupancyDetail['spa'].",";
				
				$seriesCategory['Rooms'] = (!array_key_exists('Rooms', $seriesCategory)?'':$seriesCategory['Rooms']).$OccupancyDetail['rooms'].",";
				
				
			}
			
			
			$Occupancy['data'] = $Occupancyitems;

		}
		
			//print_r($seriesCategory);
			//die();
			
			$response['Occupancy']= $Occupancy;
	}
	
	{
		
		 $OccupancyChartString = "{
				chart: {
					renderTo: 'OccupancyChart',
					type: 'column'
				},
				
				title: {
					text: 'Hotel Guest Information'
				},
				xAxis: {
					categories: [".implode(",",$chartCategory)."]
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Number of'
					},
					stackLabels: {
						enabled: true,
						style: {
							fontWeight: 'bold',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
						}
					}
				},
				legend: {
					align: 'right',
					x: -30,
					verticalAlign: 'top',
					y: 25,
					floating: true,
					backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
					borderColor: '#CCC',
					borderWidth: 1,
					shadow: false
				},
				tooltip: {
					headerFormat: '<b>{point.x}</b><br/>',
					pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
				},
				plotOptions: {
					column: {
						stacking: 'normal',
						dataLabels: {
							enabled: true,
							color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
							style: {
								textShadow: '0 0 3px black'
							}
						}
					}
				},
				series: [";
		$seriesstring = "";
		foreach($seriesCategory as $x => $x_value) {
			$seriesstring.="{name: '".$x."',data: [".rtrim($x_value, ',')."]},";
		}
		$seriesstring = rtrim($seriesstring, ',');
		$OccupancyChartString.=$seriesstring;
			
		$OccupancyChartString.="
				]
			}";
			
			//echo $OccupancyChartString;
			//die();
			$response['Occupancy']['OccupancyChart'] = $OccupancyChartString;
	}
	

    echoResponse(200, $response);
});


$app->post('/UpdateOccupancy', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->Occupancy->pk>0)
	{
		$sql = "Update mddailynewHO set ";
		$sql .= "covers = '".$r->Occupancy->covers."' , ";
		$sql .= "rooms = '".$r->Occupancy->rooms."' ,";
		$sql .= "functions = '".$r->Occupancy->functions."' ,";
		$sql .= "delegates = '".$r->Occupancy->delegates."' ,";
		$sql .= "spa = '".$r->Occupancy->spa."' ,";
		$sql .= "sleepers = '".$r->Occupancy->sleepers."' ";
		//$sql .= " where ID = '".$session['uid']."' ";
		$sql .= " where pk = '".$r->Occupancy->pk."' ";
		
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Updated occupancy details for ID : ".$r->Occupancy->pk." , date : ".$r->Occupancy->date,$r->Occupancy->hotelid,'Occupancy');
				$response["status"] = "success";
				$response["message"] = "Occupancy updated successfully";
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update your Occupancy. Please try again";
				
			}   
	}
	else
	{
		$occExists = $db->getOneRecord("select * from mddailynewHO where date='".$r->Occupancy->date."' and hotelid=".$r->Occupancy->hotelid);
		//echo "select * from mddailynewHO where date='".$r->Occupancy->date."' and hotelid=".$r->Occupancy->hotelid;
		//die();
		if ($occExists == NULL) {

			$hotelName = "";
			$getHotelName = $db->getOneRecord("select Name from creat072_vue.channel where GroupId = ".$r->Occupancy->hotelid);
			if ($getHotelName != NULL) 
				$hotelName = $getHotelName['Name'];
			
			$sql = "insert into mddailynewHO  (date, hotelid, covers, rooms, functions, delegates, spa, sleepers, hotel) values (";
			$sql .= "'".$r->Occupancy->date."', ";
			$sql .= "'".$r->Occupancy->hotelid."', ";
			$sql .= "'".$r->Occupancy->covers."' , ";
			$sql .= "'".$r->Occupancy->rooms."' ,";
			$sql .= "'".$r->Occupancy->functions."' ,";
			$sql .= "'".$r->Occupancy->delegates."' ,";
			$sql .= "'".$r->Occupancy->spa."' ,";
			$sql .= "'".$r->Occupancy->sleepers."' , ";
			$sql .= "'".$hotelName."' )";
		
			$result = $db->executeInsert($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Inserted a new occupancy information with ID : ".$result." , date : ".$r->Occupancy->date,$r->Occupancy->hotelid,'Occupancy');
				$response["status"] = "success";
				$response["message"] = "Occupancy added successfully";
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update your Occupancy. Please try again";
				
			}   
		}
		else 
		{
			$response["status"] = "error";
				$response["message"] = "An occupancy record already exists for selected hotelid and date.";
		}
	}
    echoResponse(200, $response);
	
});


$app->post('/LoadExcel', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	//print_r($r->dparams);
	//echo $r->dparams->WeatherEndDate;
	//echo $r->dparams->WeatherStartDate;
	//die();

	{ // Load Excel
		
		if($session['isadmin']=="1")
		  {
		   $sql = "  select *,
(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='F&B' and HotelID=c.hotelid) then 0 else 1 end) fb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Functions' and HotelID=c.hotelid) then 0 else 1 end) cb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='General' and HotelID=c.hotelid) then 0 else 1 end) General_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='H&F' and HotelID=c.hotelid) then 0 else 1 end) hf_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='House Keeping' and HotelID=c.hotelid) then 0 else 1 end) hk_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Plant' and HotelID=c.hotelid) then 0 else 1 end) plant_IsValid,
				
				p.Name HotelName , date_add(c.date, interval -1 day) dateminusoneday,
											   
												(case when c.nightlow=ph.NightLow then '#FFD700' when c.nightlow>ph.NightLow then '#FF6666' when c.nightlow<ph.NightLow then '#9CCB19' else '' end ) cellbgcolor,
														(case when c.hitdaymax>0 then '#FF6666' else '' end ) cellbgcolor2
			   from smdata c
			   join (select Name, GroupId from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") p
			   on (c.hotelid=p.GroupId)
																join Portal_Hotel ph
																on (ph.HotelID = c.hotelid)
			   where 
				 c.date between '".$r->dparams->ExcelStartDate."' and '".$r->dparams->ExcelEndDate."'
				order by c.hotelid, date desc
			   ";
		  }
		  else
		  {
		  
		   $sql = "  select *, 
		   
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='F&B' and HotelID=c.hotelid) then 0 else 1 end) fb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Functions' and HotelID=c.hotelid) then 0 else 1 end) cb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='General' and HotelID=c.hotelid) then 0 else 1 end) General_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='H&F' and HotelID=c.hotelid) then 0 else 1 end) hf_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='House Keeping' and HotelID=c.hotelid) then 0 else 1 end) hk_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Plant' and HotelID=c.hotelid) then 0 else 1 end) plant_IsValid,
				
				
		   p.Name HotelName, date_add(c.date, interval -1 day) dateminusoneday,
														(case when c.nightlow=ph.NightLow then '#FFD700' when c.nightlow>ph.NightLow then '#FF6666' when c.nightlow<ph.NightLow then '#9CCB19' else '' end ) cellbgcolor,
                                                (case when c.hitdaymax>0 then '#FF6666' else '' end ) cellbgcolor2
							from smdata c
							join (select Name, GroupId from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") p
							on (c.hotelid=p.GroupId)
							join Portal_UserToHotels n
							on (c.hotelid=n.HotelID)
                                                        join Portal_Hotel ph
                                                        on (ph.HotelID = c.hotelid)
							where 
							n.UserID=".$session['uid']." and  c.date between '".$r->dparams->ExcelStartDate."' and '".$r->dparams->ExcelEndDate."'
							 order by c.hotelid , date  desc
							";
		}
		//echo $sql;
		$ExcelDetails = $db->getRecords($sql);
		$Excelitems = array();
		$chartCategory =   array();
		$seriesCategory =   array();
			
		$Excel['status'] = "success";
		$Excel['message'] = 'Logged in successfully.';
		$Excel['data'] = array();

		/*$AllHotels = $db->getRecords("select * from creat072_vue.channel where parentid=1");
		foreach($AllHotels as $AllHotel)
		{
			if($session['isadmin']=="1")
				{
					$sqlq = "		select *, p.Name HotelName , date_add(c.date, interval -1 day) dateminusoneday,
														(case when c.nightlow=ph.NightLow then '#FFBF00' when c.nightlow>ph.NightLow then 'red' when c.nightlow<ph.NightLow then 'green' else '' end ) cellbgcolor,
														(case when c.hitdaymax>0 then 'red' else '' end ) cellbgcolor2
									from smdata c
									join (select Name, GroupId from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") p
									on (c.hotelid=p.GroupId)
																join Portal_Hotel ph
																on (ph.HotelID = c.hotelid)
									where 
									  c.date between '".$r->dparams->ExcelStartDate."' and '".$r->dparams->ExcelEndDate."'
									 order by c.hotelid, date desc
									";
				}
				else
				{
				
					$sqlq = "		select *, p.Name HotelName, date_add(c.date, interval -1 day) dateminusoneday,
														(case when c.nightlow=ph.NightLow then '#FFBF00' when c.nightlow>ph.NightLow then 'red' when c.nightlow<ph.NightLow then 'green' else '' end ) cellbgcolor,
														(case when c.hitdaymax>0 then 'red' else '' end ) cellbgcolor2
									from smdata c
									join (select Name, GroupId from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") p
									on (c.hotelid=p.GroupId)
									join Portal_UserToHotels n
									on (c.hotelid=n.HotelID)
																join Portal_Hotel ph
																on (ph.HotelID = c.hotelid)
									where 
									n.UserID=".$session['uid']." and  c.date between '".$r->dparams->ExcelStartDate."' and '".$r->dparams->ExcelEndDate."'
									 order by c.hotelid , date  desc
									";
				}
			$smDataHotels = $db->getRecords($sqlq);		
//if($AllHotel['GroupId']=='20')
			//print_r($smDataHotels);			
			$FBS = $db->getRecords("select FGname name from portal_InvalidFunctionalGroups where HotelID=".$AllHotel['GroupId']);
			$fb = 1;
			$fnc = 1;
			$genral = 1;
			$hf = 1;
			$hk = 1;
			$plant = 1;
			foreach($FBS as $FB)
			{
				if($FB['name']=="F&B")
					$fb = 0;
				if($FB['name']=="Functions")
					$fnc = 0;
				if($FB['name']=="General")
					$genral = 0;
				if($FB['name']=="H&F")
					$hf = 0;
				if($FB['name']=="House Keeping")
					$hk = 0;
				if($FB['name']=="Plant")
					$plant = 0;
			}
			
			foreach ($smDataHotels as $ExcelDetail) {
				
				//echo floatval($ExcelDetail['fb'])."-".floatval($ExcelDetail['cb'])."-".floatval($ExcelDetail['hf'])."-".floatval($ExcelDetail['hk'])."-".floatval($ExcelDetail['plant'])."-".floatval($ExcelDetail['General'])."<br>";
				if((floatval($ExcelDetail['fb'])<=0 && $fb==1)  || (floatval($ExcelDetail['cb'])<=0 && $fnc==1) || (floatval($ExcelDetail['hf'])<=0 && $hf==1) || (floatval($ExcelDetail['hk'])<=0  && $hk==1) || (floatval($ExcelDetail['plant'])<=0   && $plant==1) || (floatval($ExcelDetail['General'])<=0    && $genral==1) )
				{
					$Excel['colors'][] = array("GroupId"=>$AllHotel['GroupId'],'color'=>"red");
					break;
				}
				
			}
		}
		*/
		//echo $fb ."<br>";
		//echo $fnc."<br>";
		//echo $genral."<br>";
		//echo $hf."<br>";
		//echo $hk."<br>";
		//echo $plant."<br>";
		
		$fb = 1;
			$fnc = 1;
			$genral = 1;
			$hf = 1;
			$hk = 1;
			$plant = 1;
			
		if ($ExcelDetails != NULL) {

			$Excel['status'] = "success";
			$Excel['message'] = 'Logged in successfully.';
			//$color = "white";
			//foreach ($ExcelDetails as $ExcelDetail) {
				
				//echo floatval($ExcelDetail['fb'])."-".floatval($ExcelDetail['cb'])."-".floatval($ExcelDetail['hf'])."-".floatval($ExcelDetail['hk'])."-".floatval($ExcelDetail['plant'])."-".floatval($ExcelDetail['General'])."<br>";
				//if((floatval($ExcelDetail['fb'])<=0 && $fb==1)  || (floatval($ExcelDetail['cb'])<=0 && $fnc==1) || (floatval($ExcelDetail['hf'])<=0 && $hf==1) || (floatval($ExcelDetail['hk'])<=0  && $hk==1) || (floatval($ExcelDetail['plant'])<=0   && $plant==1) || (floatval($ExcelDetail['General'])<=0    && $genral==1) )
				//	$color = "red";
				
				
			//}
			foreach ($ExcelDetails as $ExcelDetail) {
				$ExcelDetail['smcontrol'] = array();
				$smcontrolDetails = $db->getRecords("select * from Portal_Hotel where HotelID=".$ExcelDetail['hotelid']." ");
				if ($smcontrolDetails != NULL) {
					foreach ($smcontrolDetails as $smcontrolDetail) {
						$ExcelDetail['smcontrol'][] = $smcontrolDetail;
					}
				}
				//$ExcelDetail['color']=$color;
				
				//$ExcelDetail['hitdaymax'] = ($ExcelDetail['hitdaymax']=="0"?false:true);
				$Excelitems[] = $ExcelDetail;
			}
			
			
				
			//$Excel['color'] = $color;
			$Excel['data'] = $Excelitems;

		}
		
		
		
		
			//print_r($seriesCategory);
			//die();
			
			$response['Excel']= $Excel;
	}
	
	
	

    echoResponse(200, $response);
});


$app->post('/LoadExcelPrintDetail', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	//print_r($r->dparams);
	//echo $r->dparams->WeatherEndDate;
	//echo $r->dparams->WeatherStartDate;
	//die();

	{ 
		$ExcelPrint = array();
		$ExcelPrintSettings = array();
		
		$excelSettingsQuery = "select * from smcontrol where hotelid=".$r->dparams->SelectedHotel; 
		$excelSettings = $db->getOneRecord($excelSettingsQuery);
		if($excelSettings!=null)
		{
			$ExcelPrintSettings = $excelSettings;
		}
		
		$HotelSettingsQuery = "select * from Portal_Hotel where HotelID=".$r->dparams->SelectedHotel; 
		$hotelSettings = $db->getOneRecord($HotelSettingsQuery);
		if($hotelSettings!=null)
		{
			if($hotelSettings['DayMax']==NULL)
				$hotelSettings['DayMax'] = 0;
			if($hotelSettings['NightLow']==NULL)
				$hotelSettings['NightLow'] = 0;
			$ExcelPrint['HotelSettings'] = $hotelSettings;
		}
		
		if($r->dparams->Date=='')
		{
		$NewDayQuery = "select *,date_format(date,'%a') dname,date_format(date,'%d/%m/%Y') dt1,date_format(fdtime,'%H:%i') fdt,date_format(ldtime,'%H:%i') ldt,
				(select Name from creat072_vue.channel where GroupId=".$r->dparams->SelectedHotel.") hotelName
				from smdata where hotelid=".$r->dparams->SelectedHotel." order by date desc "; 
		}
		else
		{
		$NewDayQuery = "select *,date_format(date,'%a') dname,date_format(date,'%d/%m/%Y') dt1,date_format(fdtime,'%H:%i') fdt,date_format(ldtime,'%H:%i') ldt,
				(select Name from creat072_vue.channel where GroupId=".$r->dparams->SelectedHotel.") hotelName
				from smdata where hotelid=".$r->dparams->SelectedHotel." and date_format(date, '%Y-%m-%d')= '".$r->dparams->Date."' order by date desc "; 
		}
		//echo $NewDayQuery;
		$ExcelPrint['hotelid'] = $r->dparams->SelectedHotel;
		$LatestRowsExists = $db->getOneRecord($NewDayQuery);

			$ExcelPrint['FBNew'] = round(0,2);
			$ExcelPrint['CBNew'] = round(0,2);
			$ExcelPrint['HFNew'] = round(0,2);
			$ExcelPrint['HKNew'] = round(0,2);
			$ExcelPrint['GeneralNew'] = round(0,2);
			$ExcelPrint['PlantNew'] = round(0,2);
			$ExcelPrint['totelSumNew']="";

		if($LatestRowsExists!=null)
		{
			$ExcelPrint['dname'] = $LatestRowsExists['dname'];
			$ExcelPrint['hotelName'] = $LatestRowsExists['hotelName'];
			$ExcelPrint['date'] = $LatestRowsExists['date'];
			$datee = $LatestRowsExists['date'];
			$ExcelPrint['dt1'] = $LatestRowsExists['dt1'];
			
			$ExcelPrint['totelSumNew'] = round(($LatestRowsExists["total"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['FirstDayNew'] = $LatestRowsExists['firstday'];
			$ExcelPrint['FirstDayTimeNew']  = $LatestRowsExists['fdt'];
			$ExcelPrint['LastDayNew'] = $LatestRowsExists['lastday'];
			$ExcelPrint['LastDayTimeNew']  = $LatestRowsExists['ldt'];
			$ExcelPrint['NightLowNew'] = $LatestRowsExists['nightlow'];
			
			
			$ExcelPrint['SmDataID'] = -1;
			$ExcelPrint['FBNew'] = round(($LatestRowsExists["fb"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['CBNew'] = round(($LatestRowsExists["cb"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['HFNew'] = round(($LatestRowsExists["hf"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['HKNew'] = round(($LatestRowsExists["hk"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['GeneralNew'] = round(($LatestRowsExists["General"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['PlantNew'] = round(($LatestRowsExists["plant"]*$ExcelPrintSettings['kwcost']),2);
			
			$ExcelPrint['FirstDayTimeHthresholdText'] = ($LatestRowsExists['firstday']==""?"We DID NOT Exceed theDaytime Threshold": "We First EXCEEDED the Daytime Threshold with");
		}

		if(!isset($datee) || $datee=="")
		{
                    $datee = $r->dparams->Date;
                    $ExcelPrint['date'] = $r->dparams->Date;
        }

		$OldDayQuery = "select *,date_format(date,'%a') dname from smdata where hotelid=".$r->dparams->SelectedHotel." and date < '$datee' order by date desc "; 
		//echo $OldDayQuery;
		$OldRowsExists = $db->getOneRecord($OldDayQuery);
		if($OldRowsExists!=null)
		{
			$ExcelPrint['totelSumOld'] = round(($OldRowsExists["total"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['Olddatee'] = $OldRowsExists['date'];

			$ExcelPrint['FBOld'] = round(($OldRowsExists["fb"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['CBOld'] = round(($OldRowsExists["cb"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['HFOld'] = round(($OldRowsExists["hf"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['HKOld'] = round(($OldRowsExists["hk"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['GeneralOld'] = round(($OldRowsExists["General"]*$ExcelPrintSettings['kwcost']),2);
			$ExcelPrint['PlantOld'] = round(($OldRowsExists["plant"]*$ExcelPrintSettings['kwcost']),2);
		}
		
                if(isset($r->dparams->Date) && $r->dparams->Date!="")
                    $dttoUse = $r->dparams->Date;
                else
                    $dttoUse = $datee;
                
		$alertCountSql ="select c.groupid, c.Name, 
		count( distinct (case when r.post_parent=0 then r.ID else r.post_parent end)) alertcount from creat072_vue.channel c
					left join (

					select *,getTopParentPositionId(groupid) grpid from creat072_vue.valert ) r
					on (c.groupid=r.grpid)

					where parentid=".$r->dparams->SelectedHotel." 
					and 
					date_format(concat(r.date,' ',r.varient),'%Y-%m-%d %H:%i:%s')  
					between '".$dttoUse." 04:30:00' and date_add('".$dttoUse." 04:30:00', interval 1 day)
					group by c.groupid, c.Name";

					//'".$dttoUse." 04:30:00' between date_format(r.date,'%Y-%m-%d 04:30:00') and date_format(r.date,'%Y-%m-%d 04:30:00')

		//echo $alertCountSql;
	
		/*$alertCountSql ="		select c.fid groupid, c.fname Name, count(*) alertcount from 
					(
						select b.name, b.groupid,c.groupid fid, c.name fname from creat072_vue.channelext c
						join  creat072_vue.channelext b
						on (b.path like concat('%/',c.groupid,'/%'))

						where c.parentid=".$r->dparams->SelectedHotel." 
					) 
					c
					left join (

					select * from creat072_vue.rpalerts ) r
					on (c.groupid=r.groupid and date_format(lastalert,'%Y-%m-%d') = '".$datee."')

					
                     
					group by c.fid, c.fname";*/
		//echo $alertCountSql;
                //print_r($r->dparams);
		
		$alertCountSqlRowsExists = $db->getRecords($alertCountSql);
		$ExcelPrint['FBAlertCount'] = "0";
		$ExcelPrint['HFAlertCount'] = "0";
		$ExcelPrint['FunctionsAlertCount'] = "0";
		$ExcelPrint['HouseKeepingAlertCount'] = "0";
		$ExcelPrint['GeneralAlertCount'] = "0";
		$ExcelPrint['PlantAlertCount'] = "0";
		if($alertCountSqlRowsExists!=null)
		{
			foreach($alertCountSqlRowsExists as $alertitem)
			{
				if($alertitem['Name']=="F&B")
				$ExcelPrint['FBAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="H&F")
				$ExcelPrint['HFAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="C&B")
				$ExcelPrint['FunctionsAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="House Keeping")
				$ExcelPrint['HouseKeepingAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="General")
				$ExcelPrint['GeneralAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="Plant")
				$ExcelPrint['PlantAlertCount'] = $alertitem['alertcount'];
			}
		}
		
		
		//$smprintQuery="Select * from smdata_PrintDetails where Hotelid='".$r->dparams->SelectedHotel."'and date_format(CreatedDate,'%Y-%m-%d')='".$datee."' order by ID desc";
		$smprintQuery="Select * from smdata_PrintDetails where Hotelid='".$r->dparams->SelectedHotel."'and date_format(CreatedDate,'%Y-%m-%d')='".$datee."' order by ID desc";

		
		
		
		$ExcelPrint['SmDataID']  = 0;
					$ExcelPrint['fbFN']= "";
					$ExcelPrint['cbFN']= "";
					$ExcelPrint['hfFN']= "";
					$ExcelPrint['hkFN']= "";
					$ExcelPrint['generalFN']= "";
					$ExcelPrint['plantFN']= "";
					$ExcelPrint['reportText'] = "";
					
		$smprintExists = $db->getOneRecord($smprintQuery);
		if($smprintExists!=null)
		{
					$ExcelPrint['SmDataID']  = $smprintExists['ID'];
					$ExcelPrint['fbFN']= stripslashes($smprintExists['fbFN']);
					$ExcelPrint['cbFN']= stripslashes($smprintExists['cbFN']);
					$ExcelPrint['hfFN']= stripslashes($smprintExists['hfFN']);
					$ExcelPrint['hkFN']= stripslashes($smprintExists['hkFN']);
					$ExcelPrint['generalFN']= stripslashes($smprintExists['generalFN']);
					$ExcelPrint['plantFN']= stripslashes($smprintExists['plantFN']);
					$ExcelPrint['reportText'] = stripslashes($smprintExists['reportText']);
					
					if($smprintExists['userid'] !== $session['uid'])
					$ExcelPrint['SmDataID'] = 0;
		}
		
		$ExcelPrint['FBUPDOWN'] = "";
		if($ExcelPrint['FBNew']!="" && $ExcelPrint['FBOld']!="")
		{
			$ExcelPrint['FBUPDOWN'] = ($ExcelPrint['FBNew']>$ExcelPrint['FBOld']?"UP":"DOWN");
			if($ExcelPrint['FBNew']>$ExcelPrint['FBOld'])
			$ExcelPrint['FBUPDOWNValue'] = $ExcelPrint['FBNew']-$ExcelPrint['FBOld'];
			else
			$ExcelPrint['FBUPDOWNValue'] = $ExcelPrint['FBOld']-$ExcelPrint['FBNew'];
		
			$ExcelPrint['FBOld'] = round($ExcelPrint['FBOld']);
		
			if($ExcelPrint['FBNew']!="0" && $ExcelPrint['FBOld']!="0")
			$ExcelPrint['FBUPDOWNPercent'] = round(($ExcelPrint['FBUPDOWNValue']/$ExcelPrint['FBOld'])*100);
			else
			$ExcelPrint['FBUPDOWNPercent'] = 0;
			
			$ExcelPrint['FBNew'] = round($ExcelPrint['FBNew']);

		}
		
		$ExcelPrint['CBUPDOWN'] = "";
		if($ExcelPrint['CBNew']!="" && $ExcelPrint['CBOld']!="")
		{
			$ExcelPrint['CBUPDOWN'] = ($ExcelPrint['CBNew']>$ExcelPrint['CBOld']?"UP":"DOWN");
			if($ExcelPrint['CBNew']>$ExcelPrint['CBOld'])
			$ExcelPrint['CBUPDOWNValue'] = $ExcelPrint['CBNew']-$ExcelPrint['CBOld'];
			else
			$ExcelPrint['CBUPDOWNValue'] = $ExcelPrint['CBOld']-$ExcelPrint['CBNew'];
		
			$ExcelPrint['CBOld'] = round($ExcelPrint['CBOld']);
		
			if($ExcelPrint['CBNew']!="0" && $ExcelPrint['CBOld']!="0")
			$ExcelPrint['CBUPDOWNPercent'] = round(($ExcelPrint['CBUPDOWNValue']/$ExcelPrint['CBOld'])*100);
			else
			$ExcelPrint['CBUPDOWNPercent'] = 0;
			
			$ExcelPrint['CBNew'] = round($ExcelPrint['CBNew']);

		}
		
		$ExcelPrint['HFUPDOWN'] = "";
		if($ExcelPrint['HFNew']!="" && $ExcelPrint['HFOld']!="")
		{
			$ExcelPrint['HFUPDOWN'] = ($ExcelPrint['HFNew']>$ExcelPrint['HFOld']?"UP":"DOWN");
			if($ExcelPrint['HFNew']>$ExcelPrint['HFOld'])
			$ExcelPrint['HFUPDOWNValue'] = $ExcelPrint['HFNew']-$ExcelPrint['HFOld'];
			else
			$ExcelPrint['HFUPDOWNValue'] = $ExcelPrint['HFOld']-$ExcelPrint['HFNew'];
		
			$ExcelPrint['HFOld'] = round($ExcelPrint['HFOld']);
		
			if($ExcelPrint['HFNew']!="0" && $ExcelPrint['HFOld']!="0")
			$ExcelPrint['HFUPDOWNPercent'] = round(($ExcelPrint['HFUPDOWNValue']/$ExcelPrint['HFOld'])*100);
			else
			$ExcelPrint['HFUPDOWNPercent'] = 0;
			
			$ExcelPrint['HFNew'] = round($ExcelPrint['HFNew']);

		}
		
		$ExcelPrint['HKUPDOWN'] = "";
		if($ExcelPrint['HKNew']!="" && $ExcelPrint['HKOld']!="")
		{
			$ExcelPrint['HKUPDOWN'] = ($ExcelPrint['HKNew']>$ExcelPrint['HKOld']?"UP":"DOWN");
			if($ExcelPrint['HKNew']>$ExcelPrint['HKOld'])
			$ExcelPrint['HKUPDOWNValue'] = $ExcelPrint['HKNew']-$ExcelPrint['HKOld'];
			else
			$ExcelPrint['HKUPDOWNValue'] = $ExcelPrint['HKOld']-$ExcelPrint['HKNew'];
		
			$ExcelPrint['HKOld'] = round($ExcelPrint['HKOld']);
		
			if($ExcelPrint['HKNew']!="0" && $ExcelPrint['HKOld']!="0")
			$ExcelPrint['HKUPDOWNPercent'] = round(($ExcelPrint['HKUPDOWNValue']/$ExcelPrint['HKOld'])*100);
			else
			$ExcelPrint['HKUPDOWNPercent'] = 0;
			
			$ExcelPrint['HKNew'] = round($ExcelPrint['HKNew']);

		}
		
		$ExcelPrint['GeneralUPDOWN'] = "";
		if($ExcelPrint['GeneralNew']!="" && $ExcelPrint['GeneralOld']!="")
		{
			$ExcelPrint['GeneralUPDOWN'] = ($ExcelPrint['GeneralNew']>$ExcelPrint['GeneralOld']?"UP":"DOWN");
			if($ExcelPrint['GeneralNew']>$ExcelPrint['GeneralOld'])
			$ExcelPrint['GeneralUPDOWNValue'] = $ExcelPrint['GeneralNew']-$ExcelPrint['GeneralOld'];
			else
			$ExcelPrint['GeneralUPDOWNValue'] = $ExcelPrint['GeneralOld']-$ExcelPrint['GeneralNew'];
		
			$ExcelPrint['GeneralOld'] = round($ExcelPrint['GeneralOld']);
		
			if($ExcelPrint['GeneralNew']!="0" && $ExcelPrint['GeneralOld']!="0")
			$ExcelPrint['GeneralUPDOWNPercent'] = round(($ExcelPrint['GeneralUPDOWNValue']/$ExcelPrint['GeneralOld'])*100);
			else
			$ExcelPrint['GeneralUPDOWNPercent'] = 0;
			
			$ExcelPrint['GeneralNew'] = round($ExcelPrint['GeneralNew']);

		}
		
		$ExcelPrint['PlantUPDOWN'] = "";
		if($ExcelPrint['PlantNew']!="" && $ExcelPrint['PlantOld']!="")
		{
			$ExcelPrint['PlantUPDOWN'] = ($ExcelPrint['PlantNew']>$ExcelPrint['PlantOld']?"UP":"DOWN");
			if($ExcelPrint['PlantNew']>$ExcelPrint['PlantOld'])
			$ExcelPrint['PlantUPDOWNValue'] = $ExcelPrint['PlantNew']-$ExcelPrint['PlantOld'];
			else
			$ExcelPrint['PlantUPDOWNValue'] = $ExcelPrint['PlantOld']-$ExcelPrint['PlantNew'];
		
			$ExcelPrint['PlantOld'] = round($ExcelPrint['PlantOld']);
		
			if($ExcelPrint['PlantNew']!="0" && $ExcelPrint['PlantOld']!="0")
			$ExcelPrint['PlantUPDOWNPercent'] = round(($ExcelPrint['PlantUPDOWNValue']/$ExcelPrint['PlantOld'])*100);
			else
			$ExcelPrint['PlantUPDOWNPercent'] = 0;
			
			$ExcelPrint['PlantNew'] = round($ExcelPrint['PlantNew']);

		}
		
		if($ExcelPrint['totelSumNew']!="" && $ExcelPrint['totelSumOld']!="")
		{
			if($ExcelPrint['totelSumNew']>$ExcelPrint['totelSumOld'])
			$ExcelPrint['totelSumDownBy'] = $ExcelPrint['totelSumNew']-$ExcelPrint['totelSumOld'];
			if($ExcelPrint['totelSumNew']<$ExcelPrint['totelSumOld'])
			$ExcelPrint['totelSumDownBy'] = $ExcelPrint['totelSumOld']-$ExcelPrint['totelSumNew'];
		
			if($ExcelPrint['totelSumNew']<$ExcelPrint['totelSumOld'])
			$ExcelPrint['totelSumDownOrUp'] = "DOWN";
			if($ExcelPrint['totelSumNew']>$ExcelPrint['totelSumOld'])
			$ExcelPrint['totelSumDownOrUp'] = "UP";
			
			if($ExcelPrint['totelSumDownBy']!="0" && $ExcelPrint['totelSumOld']!="0")
			$ExcelPrint['totelSumDownPercent'] = round(($ExcelPrint['totelSumDownBy']/$ExcelPrint['totelSumOld'])*100,2);
			else
				$ExcelPrint['totelSumDownPercent']=0;
			
			//$totelSumDownBy = round($totelSumDownBy,2)
		}
		$ExcelPrint['settings'] = $ExcelPrintSettings;
		
		
		$sql="select O.*, T.Code, c.Name wherename from Portal_OBS O JOIN Portal_ObservationsType T on (O.ObservationTypeID=T.ID) join creat072_vue.channel c on (c.GroupId=O.where) where HotelID=".$r->dparams->SelectedHotel." and ifnull(Deleted,0)=0 and PriorityNumber is not null and PriorityNumber between 1 and 10 order by PriorityNumber 
					";
					
			
			$OBSDetails = $db->getRecords($sql);
			$OBSrows = array();
			if($OBSDetails!=NULL)
			$OBSrows = $OBSDetails;
			
			$ExcelPrint['TopTenOBS'] = $OBSrows;
			//if(!isset($ExcelPrint['date']) && $ExcelPrint['date']=="")
			//	$ExcelPrint['date'] = $r->dparams->Date;
		
		$response['ExcelPrint'] = $ExcelPrint;
	}
	
	
	

    echoResponse(200, $response);
});


$app->post('/LoadExcelPrintDetailsOnDateChange', function() use ($app)  
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	
					$response['SmDataID']  = 0;
					$response['fbFN']= "";
					$response['cbFN']= "";
					$response['hfFN']= "";
					$response['hkFN']= "";
					$response['generalFN']= "";
					$response['plantFN']= "";
					$response['reportText'] = "";
	
	$smprintQuery="Select * from smdata_PrintDetails where Hotelid='".$r->dparams->SelectedHotel."'and date_format(CreatedDate,'%Y-%m-%d')='".$r->dparams->date."' order by ID desc";
		//echo $smprintQuery;
		
		$smprintExists = $db->getOneRecord($smprintQuery);
		if($smprintExists!=null)
		{
					$response['SmDataID']  = $smprintExists['ID'];
					$response['fbFN']= stripslashes($smprintExists['fbFN']);
					$response['cbFN']= stripslashes($smprintExists['cbFN']);
					$response['hfFN']= stripslashes($smprintExists['hfFN']);
					$response['hkFN']= stripslashes($smprintExists['hkFN']);
					$response['generalFN']= stripslashes($smprintExists['generalFN']);
					$response['plantFN']= stripslashes($smprintExists['plantFN']);
					$response['reportText'] = stripslashes($smprintExists['reportText']);
					if($smprintExists['userid'] !== $session['uid'])
					$response['SmDataID'] = 0;
		}

		$response['status'] = "success";
		$response['message'] = 'Loaded';
		
		/*$alertCountSql ="select c.groupid, c.Name, count(*) alertcount from creat072_vue.channel c
					left join (

					select * from creat072_vue.rpalerts ) r
					on (c.groupid=r.groupid)

					where parentid=".$r->dparams->SelectedHotel." and '".$r->dparams->date."' between date_format(FromTime,'%Y-%m-%d') and date_format(ToTime,'%Y-%m-%d')
					group by c.groupid, c.Name";
                 
                 */
               
                $alertCountSql ="select c.groupid, c.Name, count(*) alertcount from creat072_vue.channel c
					left join (

					select *,getTopParentPositionId(groupid) grpid from creat072_vue.valert ) r
					on (c.groupid=r.grpid)

					where parentid=".$r->dparams->SelectedHotel." and '".$r->dparams->date."' between date_format(r.date,'%Y-%m-%d') and date_format(r.date,'%Y-%m-%d')
					group by c.groupid, c.Name";
					
		/*$alertCountSql ="		select c.fid groupid, c.fname Name, count(*) alertcount from 
					(
						select b.name, b.groupid,c.groupid fid, c.name fname from creat072_vue.channelext c
						join  creat072_vue.channelext b
						on (b.path like concat('%/',c.groupid,'/%'))

						where c.parentid=".$r->dparams->SelectedHotel." 
					) 
					c
					left join (

					select * from creat072_vue.rpalerts ) r
					on (c.groupid=r.groupid and date_format(lastalert,'%Y-%m-%d') = '".$r->dparams->date."')

					
					group by c.fid, c.fname";*/
		
		$alertCountSqlRowsExists = $db->getRecords($alertCountSql);
		$response['FBAlertCount'] = "0";
		$response['HFAlertCount'] = "0";
		$response['FunctionsAlertCount'] = "0";
		$response['HouseKeepingAlertCount'] = "0";
		$response['GeneralAlertCount'] = "0";
		$response['PlantAlertCount'] = "0";
		if($alertCountSqlRowsExists!=null)
		{
			foreach($alertCountSqlRowsExists as $alertitem)
			{
				if($alertitem['Name']=="F&B")
				$response['FBAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="H&F")
				$response['HFAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="Functions")
				$response['FunctionsAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="House Keeping")
				$response['HouseKeepingAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="General")
				$response['GeneralAlertCount'] = $alertitem['alertcount'];
			
				if($alertitem['Name']=="Plant")
				$response['PlantAlertCount'] = $alertitem['alertcount'];
			}
		}
		
		echoResponse(200, $response);
});

$app->post('/LoadExcelChart', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	
	
	{ // Load weather
		//date_format(date,'%Y-%d-%b') dat, p.Name 
		
		if($session['isadmin']=="1")
		{
			$sql = "		select *,
			(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='F&B' and HotelID=c.hotelid) then 0 else 1 end) fb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Functions' and HotelID=c.hotelid) then 0 else 1 end) cb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='General' and HotelID=c.hotelid) then 0 else 1 end) General_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='H&F' and HotelID=c.hotelid) then 0 else 1 end) hf_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='House Keeping' and HotelID=c.hotelid) then 0 else 1 end) hk_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Plant' and HotelID=c.hotelid) then 0 else 1 end) plant_IsValid,
			date_format(date,'%d-%m-%Y') dat, p.Name 
							from smdata c
							join (select Name, GroupId from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") p
							on (c.hotelid=p.GroupId)
							where date_format(date,'%Y-%m-%d') between '".$r->dparams->ExcelStartDate."' and '".$r->dparams->ExcelEndDate."'
							 order by c.hotelid, date 
							";
		}
		else
		{
		
			$sql = "		select *,
			(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='F&B' and HotelID=c.hotelid) then 0 else 1 end) fb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Functions' and HotelID=c.hotelid) then 0 else 1 end) cb_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='General' and HotelID=c.hotelid) then 0 else 1 end) General_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='H&F' and HotelID=c.hotelid) then 0 else 1 end) hf_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='House Keeping' and HotelID=c.hotelid) then 0 else 1 end) hk_IsValid,
				(case when exists(select 1 from portal_InvalidFunctionalGroups where FGName='Plant' and HotelID=c.hotelid) then 0 else 1 end) plant_IsValid,
			date_format(date,'%d-%m-%Y') dat, p.Name 
							from smdata c
							join (select Name, GroupId from creat072_vue.channel where parentid=1 and GroupId = ".$r->dparams->SelectedHotel.") p
							on (c.hotelid=p.GroupId)
							join Portal_UserToHotels n
							on (c.hotelid=n.HotelID)
							where 
                                                        date_format(date,'%Y-%m-%d') between '".$r->dparams->ExcelStartDate."' and '".$r->dparams->ExcelEndDate."' and 
							n.UserID=".$session['uid']." 
							 order by c.hotelid , date 
							";
		}
		//echo $sql;
		$ExcelDetails = $db->getRecords($sql);
		$Excel['ExcelChartData']  = $ExcelDetails;
		//$menuitems = array();
			$chartCategory =   array();
			$seriesCategory =   array();
		if ($ExcelDetails != NULL) {

			$Excel['status'] = "success";
			$Excel['message'] = 'Logged in successfully.';
			
			foreach ($ExcelDetails as $ExcelDetail) {
				if(!in_array("'".$ExcelDetail['dat']."'", $chartCategory))
				$chartCategory[]="'".$ExcelDetail['dat']."'";
			
				//array_key_exists($weatherDetail['Name'].'_hdd', $seriesCategory)
				/*$seriesCategory[$ExcelDetail['Name'].'_total'] = (!array_key_exists($ExcelDetail['Name'].'_total', $seriesCategory)?'':$seriesCategory[$ExcelDetail['Name'].'_total']).(string)((int) ($ExcelDetail['total']*0.09)).",";
				$seriesCategory[$ExcelDetail['Name'].'_fb'] = (!array_key_exists($ExcelDetail['Name'].'_fb', $seriesCategory)?'':$seriesCategory[$ExcelDetail['Name'].'_fb']).(string)((int) ($ExcelDetail['fb']*0.09)).",";
				$seriesCategory[$ExcelDetail['Name'].'_cb'] = (!array_key_exists($ExcelDetail['Name'].'_cb', $seriesCategory)?'':$seriesCategory[$ExcelDetail['Name'].'_cb']).(string)((int) ($ExcelDetail['cb']*0.09)).",";
				$seriesCategory[$ExcelDetail['Name'].'_hf'] = (!array_key_exists($ExcelDetail['Name'].'_hf', $seriesCategory)?'':$seriesCategory[$ExcelDetail['Name'].'_hf']).(string)((int) ($ExcelDetail['hf']*0.09)).",";
				$seriesCategory[$ExcelDetail['Name'].'_hk'] = (!array_key_exists($ExcelDetail['Name'].'_hk', $seriesCategory)?'':$seriesCategory[$ExcelDetail['Name'].'_hk']).(string)((int) ($ExcelDetail['hk']*0.09)).",";
				$seriesCategory[$ExcelDetail['Name'].'_General'] = (!array_key_exists($ExcelDetail['Name'].'_General', $seriesCategory)?'':$seriesCategory[$ExcelDetail['Name'].'_General']).(string)((int) ($ExcelDetail['General']*0.09)).",";
				$seriesCategory[$ExcelDetail['Name'].'_plant'] = (!array_key_exists($ExcelDetail['Name'].'_plant', $seriesCategory)?'':$seriesCategory[$ExcelDetail['Name'].'_plant']).(string)((int) ($ExcelDetail['plant']*0.09)).",";
                                */
                
				
				$seriesCategory['Total'] = (!array_key_exists('Total', $seriesCategory)?'':$seriesCategory['Total']).(string)((int) ($ExcelDetail['total']*0.09)).",";
				if($ExcelDetail['fb_IsValid']=="1")
				$seriesCategory['F&B'] = (!array_key_exists('F&B', $seriesCategory)?'':$seriesCategory['F&B']).(string)((int) ($ExcelDetail['fb']*0.09)).",";
				if($ExcelDetail['cb_IsValid']=="1")
				$seriesCategory['C&B'] = (!array_key_exists('C&B', $seriesCategory)?'':$seriesCategory['C&B']).(string)((int) ($ExcelDetail['cb']*0.09)).",";
				if($ExcelDetail['hf_IsValid']=="1")
				$seriesCategory['H&F'] = (!array_key_exists('H&F', $seriesCategory)?'':$seriesCategory['H&F']).(string)((int) ($ExcelDetail['hf']*0.09)).",";
				if($ExcelDetail['hk_IsValid']=="1")
				$seriesCategory['House Keeping'] = (!array_key_exists('House Keeping', $seriesCategory)?'':$seriesCategory['House Keeping']).(string)((int) ($ExcelDetail['hk']*0.09)).",";
				if($ExcelDetail['General_IsValid']=="1")
				$seriesCategory['General'] = (!array_key_exists('General', $seriesCategory)?'':$seriesCategory['General']).(string)((int) ($ExcelDetail['General']*0.09)).",";
				if($ExcelDetail['plant_IsValid']=="1")
				$seriesCategory['Plant'] = (!array_key_exists('Plant', $seriesCategory)?'':$seriesCategory['Plant']).(string)((int) ($ExcelDetail['plant']*0.09)).",";
			}
			
			
			//$Excel['data'] = $menuitems;
			//print_r($chartCategory);

			//print_r($seriesCategory);
			//die();
		}
		else {
				$Excel['status'] = "error";
				$Excel['message'] = 'No such user is registered';
			}
			
			
			//$response['weather']= $weather;
	}
	
        //width: ".$r->dparams->width.",
        
	{
		$lineChartText = "{
						chart: {
							renderTo: 'ExcelGraphChart',
							type: 'line'
                                                        
                                                         
						},
						title: {
							text: 'Energy Consumption Graph'
						},
						subtitle: {
							text: ''
						},
						xAxis: {
							labels: {
									/*rotation: -45,*/
									style: {
										fontSize: '13px',
										fontFamily: 'Verdana, sans-serif'
									}
								},
							categories: [".implode(",",$chartCategory)."]
						},
						yAxis: {
							title: {
								text: 'Cost'
							}
						},
						tooltip: {
							valueSuffix: '',
							valuePrefix: '£'
						},
						";
		
		$lineChartText.="series: [";
		$seriesstring = "";
		foreach($seriesCategory as $x => $x_value) {
			$seriesstring.="{name: '".$x."',data: [".rtrim($x_value, ',')."]},";
		}
		$seriesstring = rtrim($seriesstring, ',');
		$lineChartText.=$seriesstring;
		$lineChartText.="]}";
				
			//echo $lineChartText;
			//die();		
        
				$Excel['Linechart']= $lineChartText;
				
				$response['Excel']= $Excel;
				
	}
	
	
    echoResponse(200, $response);
});

$app->post('/UpdateExcelPrintDetails', function() use ($app) {
    
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	
	$fbFN= addslashes($r->ExcelPrintDetails->fbFN);
					$cbFN= addslashes($r->ExcelPrintDetails->cbFN);
					$hfFN= addslashes($r->ExcelPrintDetails->hfFN);
					$hkFN= addslashes($r->ExcelPrintDetails->hkFN);
					$generalFN= addslashes($r->ExcelPrintDetails->generalFN);
					$plantFN= addslashes($r->ExcelPrintDetails->plantFN);
					
					$reportText = addslashes($r->ExcelPrintDetails->reportText);
					
	if($r->ExcelPrintDetails->SmDataID>0)
	{
		$sql = "update smdata_PrintDetails
					set 
					reportText = '$reportText',
					fbFN = '$fbFN',
					cbFN = '$cbFN',
					hfFN = '$hfFN',
					hkFN = '$hkFN',
					generalFN = '$generalFN',
					plantFN = '$plantFN',
					ModifiedDate = now()  
					where ID = ".$r->ExcelPrintDetails->SmDataID;
		
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Updated Excel print Details for ID : ".$r->ExcelPrintDetails->SmDataID,$r->ExcelPrintDetails->hotelid,'Update Excel Print');
				$response["ID"] = $r->ExcelPrintDetails->SmDataID;
				$response["status"] = "success";
				$response["message"] = "Print details updated successfully";
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update Print details. Please try again";
				
			}   
	}
	else
	{
		
			$sql = "INSERT INTO creat072_vue.smdata_PrintDetails
					(
					userid,
					Hotelid,
					fbFN,
					cbFN,
					hfFN,
					hkFN,
					generalFN,
					plantFN,
					CreatedDate,
					ModifiedDate, reportText)
					VALUES
					('".$session['uid']."',
					'".$r->ExcelPrintDetails->hotelid."',
					'$fbFN',
					'$cbFN',
					'$hfFN',
					'$hkFN',
					'$generalFN',
					'$plantFN', '".$r->ExcelPrintDetails->date."',now(), '$reportText')";
			
			
			
		
			$result = $db->executeInsert($sql);
			if ($result != NULL) {
				$response["ID"] = $result;
				$db->writeLog($session['uid'],"Inserted a new Excel print Detail with ID : ".$result,$r->ExcelPrintDetails->hotelid,'Update Excel Print');
				$response["status"] = "success";
				$response["message"] = "Print details added successfully";
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update your Occupancy. Please try again";
				
			}   
		
	}
	//$db->writeLog($session['uid'],"Updated Excel Print Details",$r->ExcelPrintDetails->hotelid,'Excel Print');
					
    echoResponse(200, $response);
	
});


$app->post('/LoadAlert', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	//$db->connecttowor9();
	$session = $db->getSession();
	$response = null;
	
	
	{ // Load weather
	
			$AlertSetsql="	select
						A.groupid,
						chn.name,
						A.sendto,
						concat(A.sendfrom,',',
						ifnull((select N.meta_value from creat072_vue.nlk_users U
							JOIN creat072_vue.nlk_usermeta N
							ON (U.ID=N.user_id)
							where user_email=A.sendfrom
							and N.meta_key='cc' ),'')) as sendfrom,
						#A.sendfrom sendfrom,
						A.reason,
						A.lastalert,
						AlertForTab.Value AlertFor,
						AlertRepeatTab.Value AlertRepeat,
						date_format(A.FromTime,'%H:%i') FromTime,
						date_format(A.ToTime,'%H:%i') ToTime,
						A.AlertType,
						A.AlertValue,
						AlertDayTab.Value AlertDay
					from
						creat072_vue.rpalerts A
						LEFT JOIN
						(
							select '00:05:00' Code, '5 mins' Value
							union
							select '00:30:00' Code, '30 mins' Value
							union
							select '01:00:00' Code, '1 hour' Value
							union
							select '04:00:00' Code, '4 hours' Value
							union
							select '12:00:00' Code, '12 hours' Value
							union
							select '24:00:00' Code, '1 day' Value
						) as AlertForTab
						ON (AlertForTab.Code = CAST(A.AlertFor as char))
						LEFT JOIN
						(
							select '00:05:00' Code, '5 mins' Value
							union
							select '00:30:00' Code, '30 mins' Value
							union
							select '01:00:00' Code, '1 hour' Value
							union
							select '04:00:00' Code, '4 hours' Value
							union
							select '12:00:00' Code, '12 hours' Value
							union
							select '24:00:00' Code, '1 day' Value
						) as AlertRepeatTab
						ON (AlertRepeatTab.Code = CAST(A.AlertRepeat as char))
						LEFT JOIN
						(
							select '1' Code, 'Monday' Value
							union
							select '2' Code, 'Tuesday' Value
							union
							select '3' Code, 'Wednesday' Value
							union
							select '4' Code, 'Thursday' Value
							union
							select '5' Code, 'Friday' Value
							union
							select '6' Code, 'Saturday' Value
							union
							select '0' Code, 'Sunday' Value
							union
							select '7' Code, 'Weekdays' Value
							union
							select '8' Code, 'Weekends' Value
							union
							select '9' Code, 'Everyday' Value
						) as AlertDayTab
						ON (AlertDayTab.Code = CAST(A.AlertDay as char))
						 JOIN
						(
							select distinct groupid,name from creat072_vue.channelext1
							where path like concat('%/',(select distinct groupid from creat072_vue.channel where groupid =".$r->dparams->SelectedHotel."),'/%')
						) as chn
						on (A.groupid=chn.groupid) 
						where (A.sendto like 'alert@%' OR A.sendto like '%@smsremind.com')";
	
		
		
		
				
		//echo $AlertSetsql;
		$AlertSetDetails = $db->getRecords($AlertSetsql);
		$AlertSetdatarows = array();

		if ($AlertSetDetails != NULL) {

			$Alert['status'] = "success";
			$Alert['message'] = 'Logged in successfully.';
			
			foreach ($AlertSetDetails as $AlertSetDetail) {
				$AlertSetdatarows[] = $AlertSetDetail;
			}


			$Alert['alertset'] = $AlertSetdatarows;
			
			//print_r($Alert['alertset']);

		
 
			$sql="

			create temporary table ExcelTempData
			SELECT V.ID, V.name,email,
	                             message, action,
	                           varient,modifiedDate as date,building,circuit,
	                           closedStatus,post_parent,
				(case when closed=0 then null else closed end ) closed
				,datediff(closed,date) as daysopen,
	                        (
	                            select name from creat072_vue.channel where groupid in (select getTopParentPositionId(V.groupid) )
	                                ) FGName
						FROM creat072_vue.valert V
						
						where
						user_url like concat('http://',".$r->dparams->SelectedHotel.")
						and
						(date_format(concat(date),'%Y-%m-%d') between '".$r->dparams->AlertStartDate."' and '".
						$r->dparams->AlertEndDate."') 
						
						 order by concat(date) desc,building, post_date desc ";

			//(date_format(concat(date,' ',varient),'%Y-%m-%d %H:%i:%s') between '".$r->dparams->AlertStartDate." 04:30:00' and '".$r->dparams->AlertEndDate." 04:30:00') 
						 //echo $sql;
						 //and ID=51090
						 
			$db->executeSQL($sql);
			$sql="create temporary table ExcelTempData1 SELECT post_parent	FROM ExcelTempData";
			$db->executeSQL($sql);

			$sql="
			select * from 
			ExcelTempData
			where ID not in (

					select * from ExcelTempData1
						
						
			)

			
			";
					
			//echo $sql;
			$AlertDetails = $db->getRecords($sql);
			//print_r($AlertDetails);
			$datarows = array();

			if ($AlertDetails != NULL) {

				$Alert['status'] = "success";
				$Alert['message'] = 'Logged in successfully.';
				
				foreach ($AlertDetails as $AlertDetail) {
					$datarows[] = $AlertDetail;
				}

			}
			
			$Alert['data'] = $datarows;
			//print_r($datarows);	

			$sql ="drop temporary table ExcelTempData1;";
			$db->executeSQL($sql);
			$sql ="drop temporary table ExcelTempData;";
			$db->executeSQL($sql);
                        //print_r($Alert['data']);
		}
		else 
		{
				$Alert['status'] = "error";
				$Alert['message'] = 'No rows found';
		}

	}
	
	
	//print_r($Alert);
	$response['Alert']= $Alert;
    echoResponse(200, $response);
        //echo json_encode($response);
});

$app->post('/LoadHotelSettings', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	//$db->connecttowor9();
	$session = $db->getSession();
	$response = null;
	
	
	{ // Load HotelSettings
		
			$sql="Select ID,OnSpecialMeasure, AnnualConsumption,DayMax, NightLow, date_format(SMStartDate,'%Y-%m-%d') SMStartDate, date_format(SMEndDate,'%Y-%m-%d') SMEndDate, GM_UserID, MM_UserID, HKHead_UserID, HotelID, Notes, Address , Tracker from Portal_Hotel where HotelID=".$r->dparams->SelectedHotel;
					
			
			$HotelDetails = $db->getRecords($sql);
			$datarows = null;

			if ($HotelDetails != NULL) {

				$Hotel['status'] = "success";
				$Hotel['message'] = 'Hotel details loaded successfully.';
				
				foreach ($HotelDetails as $HotelDetail) {
					
					
					$sql="Select V.*, T.Name, date_format(V.VisitDate,'%Y-%m-%d') Vdate, U.Username VisitedUserName from Portal_HotelVisits V join Portal_HotelVisitTypes T on (V.VisitTypeID = T.ID)
						JOIN Portal_Users U ON (V.VisitedUserID =  U.ID)
						where V.HotelSettingsID=".$HotelDetail['ID'] ;


						//$sql="Select *, T.Name TitleName from 
						// Portal_Users U JOIN Portal_UserTitle T on (U.Title=T.ID) JOIN  Portal_UserToHotels UH ON (UH.UserID =  U.ID)
						//where UH.HotelID=".$r->dparams->SelectedHotel ;
					
			
					$HotelVisitDetails = $db->getRecords($sql);
					$HotelVisitDetailsdatarows = array();

					if ($HotelVisitDetails != NULL) {

						foreach ($HotelVisitDetails as $HotelVisitDetail) {
							$HotelVisitDetailsdatarows[] = $HotelVisitDetail;
						}

					}
					
					$HotelDetail['HotelVisits'] = $HotelVisitDetailsdatarows;
					
					
					//$sql="Select V.*, U.Username, U.Firstname, U.Lastname, U.Email, U.Mobile,UT.Name Title, U.Notes from Portal_HotelContacts V 
					//	JOIN Portal_Users U ON (V.UserID =  U.ID) join Portal_UserTitle UT
					//	ON (U.Title = UT.ID)
					//	where V.HotelSettingsID=".$HotelDetail['ID'] ;

						$sql="Select U.*, '' resetpwd1,'' resetpwd2, UH.UserID , concat(U.Firstname,' ',U.Lastname) NameOfUser, T.Name TitleName from 
						 Portal_Users U JOIN Portal_UserTitle T on (U.Title=T.ID) JOIN  Portal_UserToHotels UH ON (UH.UserID =  U.ID)
						where U.ID not in (1,17,24,87,113) and ifnull(U.InternalUser,0)=0 and UH.HotelID=".$r->dparams->SelectedHotel ;
					
			
					$HotelContactDetails = $db->getRecords($sql);
					$HotelContactDetailsdatarows = array();

					if ($HotelContactDetails != NULL) {

						foreach ($HotelContactDetails as $HotelContactDetail) {

$othersql="Select 
									c.GroupId HotelID, c.Name HotelName
									
									from 
								 Portal_Users U JOIN  Portal_UserToHotels UH ON (UH.UserID =  U.ID)
                                 JOIN creat072_vue.channel c on (c.GroupId = UH.HotelID)
								where U.ID = ".$HotelContactDetail['UserID'];

								$associatedHotels = $db->getRecords($othersql);
								$HotelContactDetail['associatedHotels'] = $associatedHotels ;

							$HotelContactDetailsdatarows[] = $HotelContactDetail;
						}

					}
					
					$HotelDetail['HotelContacts'] = $HotelContactDetailsdatarows;
					
					
					$datarows = $HotelDetail;
					
					$datarows['OnSpecialMeasure'] = ($datarows['OnSpecialMeasure']=="1")?true:false;
				}

			}
			$Hotel['data'] = $datarows;
			
			$sql="Select U.* from Portal_Users U join Portal_UserToHotels H on (U.ID = H.UserID) where U.IsAdmin=0 AND U.Active=1 AND H.HotelID=".$r->dparams->SelectedHotel;
					
			
			$HotelUserDetails = $db->getRecords($sql);
			$HotelUserDetailsdatarows = array();

			if ($HotelUserDetails != NULL) {

				foreach ($HotelUserDetails as $HotelUserDetail) {
					$HotelUserDetailsdatarows[] = $HotelUserDetail;
				}

			}
			
			$Hotel['HotelUsers'] = $HotelUserDetailsdatarows;
			
			
			$sql="Select * from Portal_HotelVisitTypes";
					
			
			$HotelVisitTypeDetails = $db->getRecords($sql);
			$HotelVisitTypeDetailsdatarows = array();

			if ($HotelVisitTypeDetails != NULL) {

				foreach ($HotelVisitTypeDetails as $HotelVisitTypeDetail) {
					$HotelVisitTypeDetailsdatarows[] = $HotelVisitTypeDetail;
				}

			}
			
			$Hotel['VisitTypes'] = $HotelVisitTypeDetailsdatarows;
			

			$sql = "SELECT hotelid, min(date) as date, nl, dm,
					case
					when DAYOFYEAR(min(date)) between 79 AND 171 then 'Spring'
					when DAYOFYEAR(min(date)) between 172 AND 264 then 'Summer'
					when DAYOFYEAR(min(date)) between 265 AND 354 then 'Autum'
					when DAYOFYEAR(min(date)) >= 355 OR DAYOFYEAR(min(date)) <= 78 then 'Winter'
					else 'UNKNOWN'
					end as season  FROM (SELECT hotelid ,nl,dm, date FROM creat072_vue.smdata 
					where  hotelid = ".$r->dparams->SelectedHotel." 
					) a GROUP BY hotelid, nl, dm ORDER BY date desc";

			
			
		 $Hotel['data']['targetSettings'] = $db->getRecords($sql);
	}
	
	
	$titles = $db->getRecords("select * from Portal_UserTitle where ifnull(Valid,0)=1 ");
	$Hotel['titles']=$titles;
	
	$response['Hotel']= $Hotel;
    echoResponse(200, $response);
});


$app->post('/UpdateHotelSettingsChanges', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->HotelItem->ID>0)
	{
		$sql = "Update Portal_Hotel set ";
		$sql .= "OnSpecialMeasure = '".$r->HotelItem->OnSpecialMeasure."' , ";
		$sql .= "AnnualConsumption = '".$r->HotelItem->AnnualConsumption."' ,";
		$sql .= "DayMax = '".$r->HotelItem->DayMax."' ,";
		$sql .= "NightLow = '".$r->HotelItem->NightLow."' ,";
		$sql .= "SMStartDate = '".$r->HotelItem->SMStartDate."' ,";
		$sql .= "SMEndDate = '".$r->HotelItem->SMEndDate."' ,";
		$sql .= "GM_UserID = '".$r->HotelItem->GM_UserID."' ,";
		$sql .= "MM_UserID = '".$r->HotelItem->MM_UserID."' , ";
		$sql .= "Notes = '".addslashes($r->HotelItem->Notes)."' , ";
		$sql .= "Tracker = '".addslashes($r->HotelItem->Tracker)."' , ";
		$sql .= "Address = '".addslashes($r->HotelItem->Address)."' , ";
		
		$sql .= "HKHead_UserID = '".$r->HotelItem->HKHead_UserID."' ";
		$sql .= " where ID = '".$r->HotelItem->ID."' ";
		
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Updated HotelSettings Information ",$r->HotelItem->HotelID,'Hotelsettings info');
				$response["status"] = "success";
				$response["message"] = "Hotel Settings updated successfully";
				$response["ID"] = $r->HotelItem->ID;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update Hotel Settings . Please try again";
				
			}   
	}
	else
	{



			
			$sql = "insert into Portal_Hotel  (OnSpecialMeasure, AnnualConsumption,DayMax, NightLow, SMStartDate, SMEndDate, GM_UserID, MM_UserID, HKHead_UserID, Notes,Address, Tracker, HotelID) values (";
			$sql .= "'".$r->HotelItem->OnSpecialMeasure."', ";
			$sql .= "'".$r->HotelItem->AnnualConsumption."', ";
			$sql .= "'".$r->HotelItem->DayMax."', ";
			$sql .= "'".$r->HotelItem->NightLow."', ";
			$sql .= "'".$r->HotelItem->SMStartDate."' , ";
			$sql .= "'".$r->HotelItem->SMEndDate."' ,";
			$sql .= "'".$r->HotelItem->GM_UserID."' ,";
			$sql .= "'".$r->HotelItem->MM_UserID."' ,";
			$sql .= "'".$r->HotelItem->HKHead_UserID."' ,";
			$sql .= "'".addslashes($r->HotelItem->Notes)."' ,";
			$sql .= "'".addslashes($r->HotelItem->Address)."' ,";
			$sql .= "'".addslashes($r->HotelItem->Tracker)."' ,";
			$sql .= "'".$r->HotelItem->HotelID."' ) ";
		
			$result = $db->executeInsert($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Inserted HotelSettings Information ",$r->HotelItem->HotelID,'Hotelsettings info');
				$response["status"] = "success";
				$response["message"] = "Hotel Settings added successfully";
				$response["ID"] = $result;
				$r->HotelItem->ID = $result;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to add Hotel Settings. Please try again";
				
			}   

	}
	
				
	
	
    echoResponse(200, $response);
	
});


$app->post('/UpdateHotelVisit', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	$sql="Select HotelID from Portal_Hotel where ID=".$r->HotelVisit->HotelSettingsID;
	$HotelDetails = $db->getRecords($sql);
	if($r->HotelVisit->ID>0)
	{
		$sql = "Update Portal_HotelVisits set ";
		$sql .= "VisitTypeID = '".$r->HotelVisit->VisitTypeID."' , ";
		$sql .= "VisitDate = '".$r->HotelVisit->Vdate."' ,";
		$sql .= "VisitedUserID = ".$r->HotelVisit->VisitedUserID." ,";
		$sql .= "Remark = '".addslashes($r->HotelVisit->Remark)."' ,";
		$sql .= "HotelSettingsID = '".$r->HotelVisit->HotelSettingsID."' ";
		$sql .= " where ID = '".$r->HotelVisit->ID."' ";
		
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
					
				$db->writeLog($session['uid'],"Updated Hotel visit for ID : ".$r->HotelVisit->ID,$HotelDetails[0]['HotelID'],'Hotelsettings Visit');
				$response["status"] = "success";
				$response["message"] = "Hotel Visit updated successfully";
				$response["ID"] = $r->HotelVisit->ID;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update Hotel Settings . Please try again";
				
			}   
	}
	else
	{



			
			$sql = "insert into Portal_HotelVisits  (VisitTypeID, VisitDate, VisitedUserID, Remark, HotelSettingsID) values (";
			$sql .= "'".$r->HotelVisit->VisitTypeID."', ";
			$sql .= "'".$r->HotelVisit->Vdate."', ";
			//$sql .= "'".$session['uid']."', ";
			$sql .= "'".$r->HotelVisit->VisitedUserID."', ";
			$sql .= "'".addslashes($r->HotelVisit->Remark)."',";
			$sql .= "'".$r->HotelVisit->HotelSettingsID."' ) ";
		
			$result = $db->executeInsert($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Inserted new Hotel visits information : ",$HotelDetails[0]['HotelID'],'Hotelsettings Visit');
				$response["status"] = "success";
				$response["message"] = "Hotel Visit added successfully";
				$response["ID"] = $result;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to add Hotel Visit. Please try again";
				
			}   

	}
	
	
				$sql="Select V.*, T.Name ,date_format(V.VisitDate,'%Y-%m-%d') Vdate, U.Username VisitedUserName from Portal_HotelVisits V join Portal_HotelVisitTypes T on (V.VisitTypeID = T.ID) 
				JOIN Portal_Users U ON (V.VisitedUserID =  U.ID)
				where V.HotelSettingsID=".$r->HotelVisit->HotelSettingsID ;
					
			
					$HotelVisitDetails = $db->getRecords($sql);
					$HotelVisitDetailsdatarows = null;

					if ($HotelVisitDetails != NULL) {

						foreach ($HotelVisitDetails as $HotelVisitDetail) {
							$HotelVisitDetailsdatarows[] = $HotelVisitDetail;
						}

					}
					$response['HotelVisits'] = $HotelVisitDetailsdatarows;
	
	
	
    echoResponse(200, $response);
	
});


$app->post('/DeleteHotelContact', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->HotelContact->ID>0)
	{
		$sql = "Delete from Portal_HotelContacts  ";
		$sql .= " where ID = ".$r->HotelContact->ID." ";
		//echo $sql;
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
				
				/*
				$getHistory = $db->getRecords("select * from Portal_HotelContactsHistory where UserID=".$r->HotelContact->ID." and HotelID=".$r->HotelContact->SelectedHotelID." order by ID desc limit 1");
				if($getHistory!= NULL)
				{
					//print_r($getHistory);
					if($getHistory[0]['Title']!==$r->HotelContact->Title)
					{
						$db->executeSQL("Insert into Portal_HotelContactsHistory (UserID, HotelID, Title, Remark, CreatedDate) values (".$r->HotelContact->ID.",".$r->HotelContact->SelectedHotelID.",'".$r->HotelContact->Title."','Title Modified from [".$getHistory[0]['Title']."]', now())");
				
					}
				}
				*/
				$response["status"] = "success";
				$response["message"] = "Hotel Contact Deleted successfully";
				$response["ID"] = $r->HotelContact->ID;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to delete Hotel Contact . Please try again";
				
			}   
	}
	
	
	
				$sql="Select V.*, U.Username, U.Firstname, U.Lastname, U.Email, U.Mobile, UT.Name Title from Portal_HotelContacts V 
						JOIN Portal_Users U ON (V.UserID =  U.ID) join Portal_UserTitle UT
						ON (U.Title = UT.ID)
						where V.HotelSettingsID=".$r->HotelContact->HotelSettingsID ;
                        
                        
					
			
					$HotelVisitDetails = $db->getRecords($sql);
					$HotelVisitDetailsdatarows = null;

					if ($HotelVisitDetails != NULL) {

						foreach ($HotelVisitDetails as $HotelVisitDetail) {
							$HotelVisitDetailsdatarows[] = $HotelVisitDetail;
						}

					}
					$response['HotelContacts'] = $HotelVisitDetailsdatarows;
	
	
	
    echoResponse(200, $response);
	
});

$app->post('/UpdateHotelContacts', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->HotelContact->ID>0)
	{
		$sql = "Update Portal_HotelContacts set ";
		///$sql .= "Title = '".$r->HotelContact->Title."' , ";
		$sql .= "UserID = '".$r->HotelContact->UserID."' ,";
		$sql .= "HotelSettingsID = '".$r->HotelContact->HotelSettingsID."' ";
		$sql .= " where ID = '".$r->HotelContact->ID."' ";
		
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
				
				/*
				$getHistory = $db->getRecords("select * from Portal_HotelContactsHistory where UserID=".$r->HotelContact->ID." and HotelID=".$r->HotelContact->SelectedHotelID." order by ID desc limit 1");
				if($getHistory!= NULL)
				{
					//print_r($getHistory);
					if($getHistory[0]['Title']!==$r->HotelContact->Title)
					{
						$db->executeSQL("Insert into Portal_HotelContactsHistory (UserID, HotelID, Title, Remark, CreatedDate) values (".$r->HotelContact->ID.",".$r->HotelContact->SelectedHotelID.",'".$r->HotelContact->Title."','Title Modified from [".$getHistory[0]['Title']."]', now())");
				
					}
				}
				*/
				$response["status"] = "success";
				$response["message"] = "Hotel Contact updated successfully";
				$response["ID"] = $r->HotelContact->ID;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update Hotel Contact . Please try again";
				
			}   
	}
	else
	{



			
			//$sql = "insert into Portal_HotelContacts  (Title, UserID, HotelSettingsID) values (";
			$sql = "insert into Portal_HotelContacts  ( UserID, HotelSettingsID) values (";
			//$sql .= "'".$r->HotelContact->Title."', ";
			$sql .= "'".$r->HotelContact->UserID."', ";
			$sql .= "'".$r->HotelContact->HotelSettingsID."' ) ";
		
			$result = $db->executeInsert($sql);
			if ($result != NULL) {
				
				//$result2 = $db->executeSQL("Insert into Portal_HotelContactsHistory (UserID, HotelID, Title, Remark, CreatedDate) values ($result,".$r->HotelContact->SelectedHotelID.",'".$r->HotelContact->Title."','Assigned to Hotel', now())");
				
				$response["status"] = "success";
				$response["message"] = "Hotel Contact added successfully";
				$response["ID"] = $result;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to add Hotel Visit. Please try again";
				
			}   

	}
	
	
				$sql="Select V.*, U.Username, U.Firstname, U.Lastname, U.Email, U.Mobile,UT.Name Title, U.Notes from Portal_HotelContacts V 
						JOIN Portal_Users U ON (V.UserID =  U.ID) join Portal_UserTitle UT
						ON (U.Title = UT.ID)
						where V.HotelSettingsID=".$r->HotelContact->HotelSettingsID ;
					
			
					$HotelVisitDetails = $db->getRecords($sql);
					$HotelVisitDetailsdatarows = null;

					if ($HotelVisitDetails != NULL) {

						foreach ($HotelVisitDetails as $HotelVisitDetail) {
							$HotelVisitDetailsdatarows[] = $HotelVisitDetail;
						}

					}
					$response['HotelContacts'] = $HotelVisitDetailsdatarows;
	
	
	
    echoResponse(200, $response);
	
});



$app->post('/LoadCircuitDetails', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	 

			$sql = "select  (case when k.Type =3 then null else Cir.ID end) ID, k.Name, k.GroupId, k.Type,
			TRUNCATE(sum(sum_min),0) sum_min , 
			TRUNCATE(sum(sum_avg),0) sum_avg ,
			TRUNCATE(sum(sum_max),0) sum_max ,
			TRUNCATE(sum(aut_min),0) aut_min , 
			TRUNCATE(sum(aut_avg),0) aut_avg ,
			TRUNCATE(sum(aut_max),0) aut_max ,
			TRUNCATE(sum(win_min),0) win_min , 
			TRUNCATE(sum(win_avg),0) win_avg ,
			TRUNCATE(sum(win_max),0) win_max ,
			TRUNCATE(sum(spr_min),0) spr_min , 
			TRUNCATE(sum(spr_avg),0) spr_avg ,
			TRUNCATE(sum(spr_max),0) spr_max ,
			'LIST' FormType
			from
			(
				select distinct c.Name, c.GroupId , c.Type, cx.GroupId grpid from creat072_vue.channel c 
				left join creat072_vue.channelext cx on (cx.path like concat('%/',c.GroupId,'/%'))
				where c.Parentid=".$r->dparams->SelectedHotel."
			) k
			left join
			Portal_Circuit Cir
			on (Cir.groupid=k.grpid or Cir.groupid=k.GroupId)
			group by k.Name, k.GroupId , k.Type ,  (case when k.Type =3 then null else Cir.ID end)";
		

		$Circuits = $db->getRecords($sql);
		if ($Circuits != NULL) {

			$circuitRes['status'] = "success";
			$circuitRes['message'] = 'Logged in successfully.';
			$menuitems = array();
			foreach ($Circuits as $Circuit) {

				$menuitems[] = $Circuit;
			}
			
			//$circuitRes['data'] = $db->buildtree($menuitems);
			$circuitRes['data']  = $menuitems;
		}
		else {
				$circuitRes['status'] = "error";
				$circuitRes['message'] = 'No such user is registered';
			}
			
			
			$response['CircuitDetails']= $circuitRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/SaveCircuitDetails', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->dparams->ID>0)
	{
		$sql = "Update Portal_Circuit set ";
		$sql .= "groupid = '".$r->dparams->GroupId."' ,";
		$sql .= "sum_min = '".$r->dparams->sum_min."' ,";
		$sql .= "sum_avg = '".$r->dparams->sum_avg."' ,";
		$sql .= "sum_max = '".$r->dparams->sum_max."' ,";
		$sql .= "aut_min = '".$r->dparams->aut_min."' ,";
		$sql .= "aut_avg = '".$r->dparams->aut_avg."' ,";
		$sql .= "aut_max = '".$r->dparams->aut_max."' ,";
		
		$sql .= "win_min = '".$r->dparams->win_min."' ,";
		$sql .= "win_avg = '".$r->dparams->win_avg."' ,";
		$sql .= "win_max = '".$r->dparams->win_max."' ,";
		$sql .= "spr_min = '".$r->dparams->spr_min."' ,";
		$sql .= "spr_avg = '".$r->dparams->spr_avg."' ,";
		$sql .= "spr_max = '".$r->dparams->spr_max."' ";
		$sql .= " where ID = '".$r->dparams->ID."' ";
		//echo $sql;
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Updated Circuit Details for ID : ".$r->dparams->ID,NULL,'Circuit Details');
				$response["status"] = "success";
				$response["message"] = "Hotel Settings updated successfully";
				$response["ID"] = $r->dparams->ID;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to update Hotel Settings . Please try again";
				
			}   
	}
	else
	{



			
			$sql = "insert into Portal_Circuit  (groupid, sum_min, sum_avg, sum_max, aut_min, aut_avg, aut_max, win_min,win_avg, win_max, spr_min, spr_avg,spr_max) values (";
			$sql .= "'".$r->dparams->GroupId."', ";
			$sql .= "'".$r->dparams->sum_min."', ";
			$sql .= "'".$r->dparams->sum_avg."' , ";
			$sql .= "'".$r->dparams->sum_max."' ,";
			$sql .= "'".$r->dparams->aut_min."' ,";
			$sql .= "'".$r->dparams->aut_avg."' ,";
			$sql .= "'".$r->dparams->aut_max."' ,";
			$sql .= "'".$r->dparams->win_min."' ,";
			$sql .= "'".$r->dparams->win_avg."' ,";
			$sql .= "'".$r->dparams->win_max."' ,";
			$sql .= "'".$r->dparams->spr_min."' ,";
			$sql .= "'".$r->dparams->spr_avg."' ,";
			$sql .= "'".$r->dparams->spr_max."' )";
		
			$result = $db->executeInsert($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Inserted a new Circuit Detail with ID : ".$result,NULL,'Circuit Details');
				$response["status"] = "success";
				$response["message"] = "Circuit details successfully";
				$response["ID"] = $result;
				$r->dparams->ID = $result;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to add Circuit details. Please try again";
				
			}   

	}
	
				
	
	
    echoResponse(200, $response);
	
});


$app->post('/DoSaveTitle', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->dparams->ID>0)
	{
		$isTitleExists = $db->getOneRecord("select 1 from Portal_UserTitle where Name='".$r->dparams->Name."' and ID != ".$r->dparams->ID);
			if(!$isTitleExists){
				
				$sql = "Update Portal_UserTitle set ";
				$sql .= "Name = '".$r->dparams->Name."' ";
				$sql .= " where ID = '".$r->dparams->ID."' ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Title updated successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to update Title . Please try again";
						
					}   
			}
			else
			{
				$response["status"] = "error";
				$response["message"] = "A title with same name already exists";
			}
	}
	else
	{


			$isTitleExists = $db->getOneRecord("select 1 from Portal_UserTitle where Name='".$r->dparams->Name."' ");
			if(!$isTitleExists){
			
				$sql = "insert into Portal_UserTitle  (Name) values (";
				$sql .= "'".$r->dparams->Name."')";
			
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Circuit details successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add Circuit details. Please try again";
					
				}   
			}
			else
			{
				$response["status"] = "error";
				$response["message"] = "A title with same name already exists";
			}
	}
	
				
	
	
    echoResponse(200, $response);
	
});


$app->post('/DoSaveRole', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->dparams->ID>0)
	{
		$isTitleExists = $db->getOneRecord("select 1 from Portal_Roles where Name='".$r->dparams->Name."' and ID != ".$r->dparams->ID);
			if(!$isTitleExists){
				
				$sql = "Update Portal_Roles set ";
				$sql .= "Name = '".$r->dparams->Name."' ";
				$sql .= " where ID = '".$r->dparams->ID."' ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Role updated successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to update Title . Please try again";
						
					}   
			}
			else
			{
				$response["status"] = "error";
				$response["message"] = "A Role with same name already exists";
			}
	}
	else
	{


			$isTitleExists = $db->getOneRecord("select 1 from Portal_Roles where Name='".$r->dparams->Name."' ");
			if(!$isTitleExists){
			
				$sql = "insert into Portal_Roles  (Name) values (";
				$sql .= "'".$r->dparams->Name."')";
			
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Role Added successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add role details. Please try again";
					
				}   
			}
			else
			{
				$response["status"] = "error";
				$response["message"] = "A Role with same name already exists";
			}
	}
	
				
	
	
    echoResponse(200, $response);
	
});


$app->post('/DoSaveWidgetOrder', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	//print_r($r->dparams);
	//die();
	foreach($r->dparams->WidgetsOrder as $worder)
	{
		//print_r($worder);
		$isTitleExists = $db->getOneRecord("select 1 from Portal_WidgetOrderToRoles where WidgetMasterID='".$worder->ID."' and RoleID = ".$r->dparams->ID);
			if($isTitleExists){
				
				$sql = "Update Portal_WidgetOrderToRoles set ";
				$sql .= "WidgetOrder = '".$worder->WidgetOrder."' ";
				$sql .= " where WidgetMasterID='".$worder->ID."' and RoleID = ".$r->dparams->ID;
				//echo $sql;
					$result = $db->executeSQL($sql);
					
			}
			else
			{
				$sql = "insert into Portal_WidgetOrderToRoles  (RoleID,WidgetMasterID,WidgetOrder) values (";
				$sql .= "'".$r->dparams->ID."','".$worder->ID."','".$worder->WidgetOrder."')";
			//echo $sql;
				$result = $db->executeInsert($sql);
			}
	}
	
	
				
	$response["status"] = "success";
						$response["message"] = "Role updated successfully";
						
	
    echoResponse(200, $response);
	
});


$app->post('/DoSaveTitleToRole', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->dparams->ID>0)
	{

				
				$sql = "Update Portal_UserTitleToRoles set ";
				$sql .= "UserTitleID = '".$r->dparams->UserTitleID."', ";
				$sql .= "RoleID = '".$r->dparams->RoleID."', ";
				$sql .= "Active = ".$r->dparams->Active." ";
				$sql .= " where ID = '".$r->dparams->ID."' ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Tile to Role updated successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to update Title to Role . Please try again";
						
					}   
			
	}
	else
	{


			
			
				$sql = "insert into Portal_UserTitleToRoles  (UserTitleID,RoleID, Active) values (";
				$sql .= "'".$r->dparams->UserTitleID."',";
				$sql .= "'".$r->dparams->RoleID."',";
				$sql .= "".$r->dparams->Active.")";
			
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Title to Role Added successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add title to role details. Please try again";
					
				}   
			
	}
	
				
	
	
    echoResponse(200, $response);
	
});

$app->post('/DoSaveRoleToPermission', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->dparams->ID>0)
	{

				
				$sql = "Update Portal_RolesToPermissions set ";
				$sql .= "RoleID = '".$r->dparams->RoleID."', ";
				$sql .= "PermissionID = '".$r->dparams->PermissionID."', ";
				$sql .= "Active = ".$r->dparams->Active." ";
				$sql .= " where ID = '".$r->dparams->ID."' ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Role to permission updated successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to update Role to permission . Please try again";
						
					}   
			
	}
	else
	{


			
			
				$sql = "insert into Portal_RolesToPermissions  (RoleID,PermissionID, Active) values (";
				$sql .= "'".$r->dparams->RoleID."',";
				$sql .= "'".$r->dparams->PermissionID."',";
				$sql .= "".$r->dparams->Active.")";
			
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Role to permission Added successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add Role to permission details. Please try again";
					
				}   
			
	}
	
				
	
	
    echoResponse(200, $response);
	
});


$app->post('/DeleteCircuitDetails', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->dparams->ID>0)
	{
		$sql = "delete from Portal_Circuit  ";
		$sql .= " where ID = '".$r->dparams->ID."' ";
		//echo $sql;
			$result = $db->executeSQL($sql);
			if ($result != NULL) {
				$db->writeLog($session['uid'],"Deleted circuit Details with ID : ".$r->dparams->ID,NULL,'Update Circuit');
				$response["status"] = "success";
				$response["message"] = "Circuit Details Deleted successfully";
				$response["ID"] = 0;
				
			} else {
				$response["status"] = "error";
				$response["message"] = "Failed to delete Circuit Details . Please try again";
				
			}   
	}
	
	
				
	
	
    echoResponse(200, $response);
	
});







$app->post('/SaveObservationChanges', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	if($r->dparams->TypeID==1)
	{
		if($r->dparams->Info->ID>0)
		{
			$sql = "Update Portal_SMitems set ";
			$sql .= "ObservationID = '".$r->dparams->ID."' ,";
			$sql .= "statusID = '".$r->dparams->Info->statusID."' ,";
			$sql .= "categoryID = '".$r->dparams->Info->categoryID."' ,";
			$sql .= "fundingID = '".$r->dparams->Info->fundingID."' ,";
			$sql .= "annual_saving = '".$r->dparams->Info->annual_saving."' ,";
			$sql .= "cost = '".$r->dparams->Info->cost."' ,";
			$sql .= "what = '".$r->dparams->Info->what."' ,";
			
			$sql .= "why = '".$r->dparams->Info->why."' ,";
			$sql .= "ref = '".$r->dparams->Info->ref."' ";
			$sql .= " where ID = '".$r->dparams->Info->ID."' ";
			//echo $sql;
				$result = $db->executeSQL($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation updated successfully";
					$response["ID"] = $r->dparams->ID;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update Observation . Please try again";
					
				}   
		}
		else
		{



				
				$sql = "insert into Portal_SMitems  (ObservationID, statusID, categoryID, fundingID, annual_saving, cost, what, why,ref) values (";
				$sql .= "'".$r->dparams->ID."', ";
				$sql .= "'".$r->dparams->Info->statusID."', ";
				$sql .= "'".$r->dparams->Info->categoryID."' , ";
				$sql .= "'".$r->dparams->Info->fundingID."' ,";
				$sql .= "'".$r->dparams->Info->annual_saving."' ,";
				$sql .= "'".$r->dparams->Info->cost."' ,";
				$sql .= "'".$r->dparams->Info->what."' ,";
				$sql .= "'".$r->dparams->Info->why."' ,";
				$sql .= "'".$r->dparams->Info->ref."')";
			
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation details added successfully";
					$response["ID"] = $result;
					$r->dparams->Info->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add Observation details. Please try again";
					
				}   

		}
		
	}			
	
	
	if($r->dparams->TypeID==2)
	{
		if($r->dparams->Info->ID>0)
		{
			$sql = "Update Portal_GMitems set ";
			$sql .= "ObservationID = '".$r->dparams->ID."' ,";
			$sql .= "DateSet = '".$r->dparams->Info->DateSet."' ,";
			$sql .= "what = '".$r->dparams->Info->what."' ,";
			
			$sql .= "ActionsRequired = '".$r->dparams->Info->ActionsRequired."' ,";
			$sql .= "DateActioned = '".$r->dparams->Info->DateActioned."' , ";
			$sql .= "ValuesPerAnnum = '".$r->dparams->Info->ValuesPerAnnum."' ";
			$sql .= " where ID = '".$r->dparams->Info->ID."' ";
			//echo $sql;
				$result = $db->executeSQL($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation updated successfully";
					$response["ID"] = $r->dparams->ID;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update Observation . Please try again";
					
				}   
		}
		else
		{



				
				$sql = "insert into Portal_GMitems  (ObservationID, DateSet, what, ActionsRequired, DateActioned, ValuesPerAnnum) values (";
				$sql .= "'".$r->dparams->ID."', ";
				$sql .= "'".$r->dparams->Info->DateSet."', ";
				$sql .= "'".$r->dparams->Info->what."' , ";
				$sql .= "'".$r->dparams->Info->ActionsRequired."' ,";
				$sql .= "'".$r->dparams->Info->DateActioned."' ,";
				$sql .= "'".$r->dparams->Info->ValuesPerAnnum."')";
			//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation details added successfully";
					$response["ID"] = $result;
					$r->dparams->Info->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add Observation details. Please try again";
					
				}   

		}
		
	}			
	
	
	if($r->dparams->TypeID==3)
	{
		if($r->dparams->Info->ID>0)
		{
			$sql = "Update Portal_OBSitems set ";
			$sql .= "ObservationID = '".$r->dparams->ID."' ,";
			$sql .= "DiscoveredDate = '".$r->dparams->Info->DiscoveredDate."' ,";
			$sql .= "what = '".$r->dparams->Info->what."' ,";
			$sql .= "Circuit = '".$r->dparams->Info->Circuit."' ,";
			$sql .= "ShortDescription = '".$r->dparams->Info->ShortDescription."' , ";
			$sql .= "Description = '".$r->dparams->Info->Description."' , ";
			$sql .= "ActionRequired = '".$r->dparams->Info->ActionRequired."' , ";
			$sql .= "SuccessCloseCriteria = '".$r->dparams->Info->SuccessCloseCriteria."' , ";
			$sql .= "Status = '".$r->dparams->Info->Status."' , ";
			$sql .= "DateComtelCompleted = '".$r->dparams->Info->DateComtelCompleted."' , ";
			$sql .= "DateRpActioned = '".$r->dparams->Info->DateRpActioned."' , ";
			$sql .= "ValuePerAnnum = '".$r->dparams->Info->ValuePerAnnum."' , ";
			$sql .= "Calcs = '".$r->dparams->Info->Calcs."'  ";
			$sql .= " where ID = '".$r->dparams->Info->ID."' ";
			//echo $sql;
				$result = $db->executeSQL($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation updated successfully";
					$response["ID"] = $r->dparams->ID;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update Observation . Please try again";
					
				}   
		}
		else
		{



				
				$sql = "insert into Portal_OBSitems  (ObservationID, DiscoveredDate, what, Circuit, ShortDescription, Description,ActionRequired,SuccessCloseCriteria,Status,DateComtelCompleted,DateRpActioned,ValuePerAnnum,Calcs) values (";
				$sql .= "'".$r->dparams->ID."', ";
				$sql .= "'".$r->dparams->Info->DiscoveredDate."', ";
				$sql .= "'".$r->dparams->Info->what."' , ";
				$sql .= "'".$r->dparams->Info->Circuit."' ,";
				$sql .= "'".$r->dparams->Info->ShortDescription."' ,";
				$sql .= "'".$r->dparams->Info->Description."' ,";
				$sql .= "'".$r->dparams->Info->ActionRequired."' ,";
				$sql .= "'".$r->dparams->Info->SuccessCloseCriteria."' ,";
				$sql .= "'".$r->dparams->Info->Status."' ,";
				$sql .= "'".$r->dparams->Info->DateComtelCompleted."' ,";
				$sql .= "'".$r->dparams->Info->DateRpActioned."' ,";
				$sql .= "'".$r->dparams->Info->ValuePerAnnum."' ,";
				$sql .= "'".$r->dparams->Info->Calcs."')";
			//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation details added successfully";
					$response["ID"] = $result;
					$r->dparams->Info->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add Observation details. Please try again";
					
				}   

		}
		
	}			
	
	
	
	
    echoResponse(200, $response);
	
});


$app->post('/ObservationImageupload', function() use ($app)      
{

    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();

	if(!empty($_FILES['image'])){
		$ext = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
                $image = time().'.'.$ext;
				$sql = "insert into Portal_ObservationImages  (ObservationID, ImageFileName) values (";
				$sql .= "'".$_POST['ObservationID']."', ";
				$sql .= "'')";
			//echo $sql;
				$result = $db->executeInsert($sql);
				$ID = $result;
				$image = $ID.$image; 
				$sql = "Update Portal_ObservationImages  set ImageFileName='".$image."' where ID=".$ID;
				$db->executeSQL($sql);
                move_uploaded_file($_FILES["image"]["tmp_name"], 'ObservationImages/'.$image);
		//echo "Image uploaded successfully as ".$image;
		$response["status"] = "success";
		$response["message"] = "Image uploaded successfully as ".$image;
	}else{
		//echo "Image Is Empty";
		$response["status"] = "success";
		$response["message"] = "Image Is Empty";
	}
	
	echoResponse(200, $response);
});





$app->post('/LoadObservationsImages', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	$ObservationRes = null;
	{ // Load channel
	 

		
		$sql = "select *  from Portal_ObservationImages where ObservationID=".$r->dparams->ID;
			
		

		$ObservationsTypes = $db->getRecords($sql);
		$Typeitems = array();
		if ($ObservationsTypes != NULL) {

			
			
			foreach ($ObservationsTypes as $ObservationsType) {

				
				$Typeitems[] = $ObservationsType;
			}
			
		}
		
		$ObservationRes['ImageList']  = $Typeitems;
			
			$response['ObservationsImages']= $ObservationRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/DeleteObservationImage', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	
		$sql = "select *  from Portal_ObservationImages where ID=".$r->dparams->ID;

		$imglist = $db->getRecords($sql);
		
		unlink("ObservationImages/".$imglist[0]['ImageFileName']);
			
	 
		$sql = "Delete from Portal_ObservationImages where ID=".$r->dparams->ID;

		$db->executeSQL($sql);
		
	}
	

	
	$response["status"] = "success";
	$response["message"] = "Image Deleted";
	
	
    echoResponse(200, $response);
});


$app->post('/DeleteOBS', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // delete images
	
		/*
		$sql = "select *  from Portal_ObservationImages where ObservationID=".$r->dparams->ID;

		$imglist = $db->getRecords($sql);
		foreach ($imglist as $img)
		{
			if(file_exists("ObservationImages/".$img['ImageFileName']))
			{
			unlink("ObservationImages/".$img['ImageFileName']);
			$sql = "Delete from Portal_ObservationImages where ID=".$img['ID'];

			$db->executeSQL($sql);
			}
			
		}
		
		
	 
		//$sql = "Delete from Portal_OBS where ParentID=".$r->dparams->ID;

		//$db->executeSQL($sql);
		
		//$sql = "Delete from Portal_OBS where ID=".$r->dparams->ID;

		//$db->executeSQL($sql);
		*/
		$sql = "Update Portal_OBS set deleted=1, DeletedUserID=".$session['uid'].", DeletedDate=NOW() where ID=".$r->dparams->ID;

		$db->executeSQL($sql);
		
	}
	

	
	$response["status"] = "success";
	$response["message"] = "Observation Deleted";
	
	
    echoResponse(200, $response);
});



$app->post('/PrepareOBSAdd', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	 

			$sql = "select O.*  from (select * from Portal_OBS where 
						1=2 and HotelID =".$r->dparams->SelectedHotel.") O
						right JOIN (select 1 kk)  OT ON (1=1)
						 order by O.ID";
			
		//echo $sql;

		$Observations = $db->getRecords($sql);
		$menuitems = array();
		if ($Observations != NULL) {

			$ObservationRes['status'] = "success";
			$ObservationRes['message'] = 'Logged in successfully.';
			
			//foreach ($Observations as $Observation) {
				
				
				//$menuitems[] = $Observation;
			//}
			
			
					//$imagesql = "select I.*  from Portal_ObservationImages I where 1=2";
				
			

					//$ImageData = $db->getRecords($imagesql);
					//$Observations[0]['ImageSet']= $ImageData;
				
				
			
			$ObservationRes['Info']  = $Observations[0];
		}
		else {
				$ObservationRes['status'] = "error";
				$ObservationRes['message'] = 'No such user is registered';
				$ObservationRes['data'] = null;
			}

		
			
			$response['PrepareOBSAddDetails']= $ObservationRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/SaveOBSChanges', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
			

		if($r->dparams->ID>0)
		{
			$sql = "Update Portal_OBS set ";
			$sql .= "HotelID = '".$r->dparams->HotelID."' ,";
			$sql .= "ObservationTypeID = '".$r->dparams->ObservationTypeID."' ,";
			$sql .= "CategoryID = '".$r->dparams->CategoryID."' ,";
			$sql .= "StatusID = '".$r->dparams->StatusID."' ,";
			$sql .= "flag5k = '".$r->dparams->flag5k."' ,";
			$sql .= "FundingID = '".$r->dparams->FundingID."' ,";
			$sql .= "DiscoveredDate = '".$r->dparams->DiscoveredDate."' ,";
			$sql .= "`where` = '".$r->dparams->where."' ,";
			$sql .= "what = '".addslashes($r->dparams->what)."' ,";
			$sql .= "Circuit = '".$r->dparams->Circuit."' ,";
			$sql .= "ShortDescription = '".addslashes($r->dparams->ShortDescription)."' , ";
			$sql .= "Description = '".addslashes($r->dparams->Description)."' , ";
			$sql .= "ActionRequired = '".addslashes($r->dparams->ActionRequired)."' , ";
			$sql .= "SuccessCloseCriteria = '".addslashes($r->dparams->SuccessCloseCriteria)."' , ";
			$sql .= "DateHotelCompleted = ".($r->dparams->DateHotelCompleted==''?'NULL':"'".$r->dparams->DateHotelCompleted."'").",";
			$sql .= "DateRpActioned = ".($r->dparams->DateRpActioned==''?'NULL':"'".$r->dparams->DateRpActioned."'").",";
			$sql .= "ValuePerAnnum = '".addslashes($r->dparams->ValuePerAnnum)."' , ";
			$sql .= "ValuePerAnnumStatus_est = '".$r->dparams->ValuePerAnnumStatus_est."' , ";
			$sql .= "ValuePerAnnumStatus_upto = '".$r->dparams->ValuePerAnnumStatus_upto."' , ";
			$sql .= "ValuePerAnnumStatus_tbd = '".$r->dparams->ValuePerAnnumStatus_tbd."' , ";
			$sql .= "ValuePerAnnumStatus_na = '".$r->dparams->ValuePerAnnumStatus_na."' , ";
			$sql .= "Calcs = '".addslashes($r->dparams->Calcs)."',   ";
			$sql .= "PriorityNumber = ".($r->dparams->PriorityNumber==''?'NULL':$r->dparams->PriorityNumber)."  ";
			$sql .= " where ID = '".$r->dparams->ID."' ";
			//echo $sql;
				$result = $db->executeSQL($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation updated successfully";
					$response["ID"] = $r->dparams->ID;
					$db->writeLog($session['uid'],"Modified an observation with RefID:".$r->dparams->ID,$r->dparams->HotelID);
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update Observation . Please try again";
					
				}   
		}
		else
		{



				
				$sql = "insert into Portal_OBS  (UserID,HotelID,ObservationTypeID,CategoryID,StatusID,FundingID, DiscoveredDate,`where`, what, Circuit, ShortDescription, Description,ActionRequired,SuccessCloseCriteria,DateHotelCompleted,DateRpActioned,ValuePerAnnum,Calcs, PriorityNumber, 
				ValuePerAnnumStatus_est,ValuePerAnnumStatus_upto,ValuePerAnnumStatus_tbd,ValuePerAnnumStatus_na,flag5k, CreatedDate 
				 ) values (";
				$sql .= $session['uid'].", ";
                                $sql .= "'".$r->dparams->HotelID."', ";
				$sql .= "'".$r->dparams->ObservationTypeID."', ";
				$sql .= "'".$r->dparams->CategoryID."', ";
				$sql .= "'".$r->dparams->StatusID."', ";
				$sql .= "'".$r->dparams->FundingID."', ";
				$sql .= "'".$r->dparams->DiscoveredDate."', ";
				$sql .= "'".$r->dparams->where."' , ";
				$sql .= "'".addslashes($r->dparams->what)."' , ";
				$sql .= "'".$r->dparams->Circuit."' ,";
				$sql .= "'".addslashes($r->dparams->ShortDescription)."' ,";
				$sql .= "'".addslashes($r->dparams->Description)."' ,";
				$sql .= "'".addslashes($r->dparams->ActionRequired)."' ,";
				$sql .= "'".addslashes($r->dparams->SuccessCloseCriteria)."' ,";
				$sql .= ($r->dparams->DateHotelCompleted==''?'NULL':"'".$r->dparams->DateHotelCompleted."'").",";
				$sql .= ($r->dparams->DateRpActioned==''?'NULL':"'".$r->dparams->DateRpActioned."'").",";
				//$sql .= "'".$r->dparams->DateRpActioned."' ,";
				$sql .= "'".addslashes($r->dparams->ValuePerAnnum)."' ,";
				$sql .= "'".addslashes($r->dparams->Calcs)."' , ";
				$sql .= "".($r->dparams->PriorityNumber==''?'NULL':$r->dparams->PriorityNumber)." , ";
				$sql .= "'".$r->dparams->ValuePerAnnumStatus_est."' , ";
				$sql .= "'".$r->dparams->ValuePerAnnumStatus_upto."' , ";
				$sql .= "'".$r->dparams->ValuePerAnnumStatus_tbd."' , ";
				$sql .= "'".$r->dparams->ValuePerAnnumStatus_na."' , ";
				$sql .= "'".$r->dparams->flag5k."' , ";
				$sql .= "now())";
			//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation details added successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					$db->writeLog($session['uid'],"Added a new observation with RefID ".$result,$r->dparams->HotelID);
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add Observation details. Please try again";
					
				}   

		}
		
				
	
	
	
	
    echoResponse(200, $response);
	
});


$app->post('/LoadOBSDetailsTobeDeleted', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	$ObservationRes = null;
	{ // Load channel
	 

		$SMTypes = $db->getRecords("SELECT * FROM Portal_ObservationsType");
		if($SMTypes!=null)
		{
			foreach ($SMTypes as $SmType) {

			}
		}

		
		$sql = "select
				O.ID,HotelID,CategoryID,StatusID,FundingID,ObservationTypeID,
				date_format(DiscoveredDate,'%Y-%m-%d') DiscoveredDate,`where`,what,
			Circuit,ShortDescription,Description,ActionRequired,SuccessCloseCriteria,
			date_format(DateHotelCompleted,'%Y-%m-%d')  DateHotelCompleted,
			 date_format(DateRpActioned,'%Y-%m-%d')  DateRpActioned,
			ValuePerAnnum,Calcs,
			CreatedDate,
			O.ParentID,PriorityNumber
			, 
			ValuePerAnnumStatus_est,ValuePerAnnumStatus_upto,ValuePerAnnumStatus_tbd,ValuePerAnnumStatus_na,
			OT.Name ObservationTypeName, CT.Name CategoryName, ST.Name StatusName, FT.Name FundingName, c.Name whereName  ";
		
		if($session['isadmin']!=1)
			$sql .=" , ifnull(InDropdown,0) InDropdown, ifnull(InView,0) InView, ifnull(CanEdit,0) CanEdit	";
		else
			$sql .=" , 1 InDropdown,1 InView, 1 CanEdit		";
		
		$sql .="from Portal_OBS O 
			JOIN Portal_ObservationsType OT
			ON (O.ObservationTypeID=OT.ID) 
			JOIN Portal_ObservationCategory CT
			ON (O.CategoryID=CT.ID) 
			JOIN Portal_ObservationStatus ST
			ON (O.StatusID=ST.ID)
			JOIN Portal_ObservationFunding FT
			ON (O.FundingID=FT.ID)	
			JOIN creat072_vue.channel c 
			ON (O.`where` = c.GroupID) ";

			if($session['isadmin']!=1)
			$sql .="	
			JOIN 
				(
					select distinct RO.* from 
						(select * from Portal_Users where ID=".$session['uid'].") U
					join Portal_UserTitle UT
					on (U.Title = UT.ID)
					join Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID and UR.Active=1)
					join Portal_RolesToObservationStatus RO
					on (UR.RoleID = RO.RoleID)
				) URO
			on (ST.ID = URO.ObservationStatusID)";
			
			$sql .="
			where ";
			
			if($session['isadmin']!=1)
			$sql .="	URO.InView=1 AND exists ("
                                . "select * from 
						(select * from Portal_Users where ID=".$session['uid'].") U
					join Portal_UserTitle UT
					on (U.Title = UT.ID)
					join Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID and UR.Active=1)
                                        join Portal_Roles R
                                        ON (UR.RoleID= R.ID)
                                        JOIN Portal_RolesToPermissions RP
                                        ON (R.ID = RP.RoleiD)
                                        JOIN Portal_Permissions P
                                        ON (RP.PermissionID = P.ID)
                                        where P.Name like concat('ObservationWhere_',c.Name)  and RP.Active=1) AND ";
		
			$sql .=" O.ObservationTypeID=3 AND O.ParentID IS NULL and ifnull(O.Deleted,0)=0  AND O.HotelID=".$r->dparams->SelectedHotel;
			
		
		echo $sql ;
		
		$ObservationsTypes = $db->getRecords($sql);
		$Typeitems = array();
                $AllTypeitems = array();
		if ($ObservationsTypes != NULL) {

			
			
			foreach ($ObservationsTypes as $ObservationsType) {

					$childsql = "select O.*, concat(U.Firstname,' ',U.Lastname) UserName, ST.Name StatusName from 
					Portal_OBS O
					JOIN Portal_ObservationStatus ST
						ON (O.StatusID=ST.ID)
					 left join Portal_Users U on (O.UserID=U.ID) where O.ParentID =".$ObservationsType['ID']." 
                    union all
                    select k.*,'' k from 
					(	select * from 
						Portal_OBS where 1=2
					) k right join (select 1 num ) t ON (1=1)
					";
					
				

				$ChildItems = $db->getRecords($childsql);
				$icount=0;
				foreach ($ChildItems as $ChildItem) {
					if($ChildItems[$icount]['ID']===NULL)
						$ChildItems[$icount]['ID']=0;
					
					$ChildItems[$icount]['ParentID']=$ObservationsType['ID'];
					
					$icount++;
				}
					
				$ObservationsType['Replies']=$ChildItems;
				
				$imagesql = "select I.*  from Portal_ObservationImages I where ObservationID = ".$ObservationsType['ID'];
				$ObservationsType['ImageSet'] = array();
			

					$ImageData = $db->getRecords($imagesql);
					if($ImageData!=NULL)
					$ObservationsType['ImageSet']= $ImageData;
			
				$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationsType['where']."/%'";
				$funcgr = $db->getRecords($sql);
				if ($funcgr != NULL) {
					$funitems = array();
					foreach ($funcgr as $fun) {
						$funitems[] = $fun;
					}
					$ObservationsType['CircuitList']  = $funitems;
				}
				
				$Typeitems[] = $ObservationsType;
                                $ObservationsType['itemType'] = "SM";
                                $AllTypeitems[] = $ObservationsType;
			}
			
		}
		
		$ObservationRes['SMdata']  = $Typeitems;
		
		$sql = "select O.ID,HotelID,CategoryID,StatusID,FundingID,ObservationTypeID,
				date_format(DiscoveredDate,'%Y-%m-%d') DiscoveredDate,`where`,what,
			Circuit,ShortDescription,Description,ActionRequired,SuccessCloseCriteria,
			date_format(DateHotelCompleted,'%Y-%m-%d')  DateHotelCompleted,
			 date_format(DateRpActioned,'%Y-%m-%d')  DateRpActioned,
			ValuePerAnnum,Calcs,
			CreatedDate,
			O.ParentID,PriorityNumber
			,ValuePerAnnumStatus_est,ValuePerAnnumStatus_upto,ValuePerAnnumStatus_tbd,ValuePerAnnumStatus_na
			, OT.Name ObservationTypeName, CT.Name CategoryName, ST.Name StatusName, FT.Name FundingName ,c.Name whereName  ";
		
		if($session['isadmin']!=1)
			$sql .=" , ifnull(InDropdown,0) InDropdown, ifnull(InView,0) InView, ifnull(CanEdit,0) CanEdit	";
		else
			$sql .=" , 1 InDropdown,1 InView, 1 CanEdit		";
		
		$sql .=" from Portal_OBS O 
			JOIN Portal_ObservationsType OT
			ON (O.ObservationTypeID=OT.ID) 
			JOIN Portal_ObservationCategory CT
			ON (O.CategoryID=CT.ID) 
			JOIN Portal_ObservationStatus ST
			ON (O.StatusID=ST.ID)
			JOIN Portal_ObservationFunding FT
			ON (O.FundingID=FT.ID)	
			JOIN creat072_vue.channel c 
			ON (O.`where` = c.GroupID) ";

			if($session['isadmin']!=1)
			$sql .="	
			JOIN 
				(
					select distinct RO.* from 
						(select * from Portal_Users where ID=".$session['uid'].") U
					join Portal_UserTitle UT
					on (U.Title = UT.ID)
					join Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID and UR.Active=1)
					join Portal_RolesToObservationStatus RO
					on (UR.RoleID = RO.RoleID)
				) URO
			on (ST.ID = URO.ObservationStatusID)";
			
			$sql .="
			where ";
			
			if($session['isadmin']!=1)
			$sql .="	URO.InView=1  AND exists ("
                                . "select * from 
						(select * from Portal_Users where ID=".$session['uid'].") U
					join Portal_UserTitle UT
					on (U.Title = UT.ID)
					join Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID and UR.Active=1)
                                        join Portal_Roles R
                                        ON (UR.RoleID= R.ID)
                                        JOIN Portal_RolesToPermissions RP
                                        ON (R.ID = RP.RoleiD)
                                        JOIN Portal_Permissions P
                                        ON (RP.PermissionID = P.ID)
                                        where P.Name like concat('ObservationWhere_',c.Name)  and RP.Active=1) AND ";
		
			$sql .=" O.ObservationTypeID=2
			AND O.ParentID IS NULL and ifnull(O.Deleted,0)=0 AND O.HotelID=".$r->dparams->SelectedHotel;
			
		

		$ObservationsTypes = $db->getRecords($sql);
		$Typeitems = array();
		if ($ObservationsTypes != NULL) {

			
			
			foreach ($ObservationsTypes as $ObservationsType) {

				$childsql = "select O.*, concat(U.Firstname,' ',U.Lastname) UserName from 
					Portal_OBS O left join Portal_Users U on (O.UserID=U.ID) where O.ParentID =".$ObservationsType['ID']." 
                    union all
                    select k.*,'' k from 
					(	select * from 
						Portal_OBS where 1=2
					) k right join (select 1 num ) t ON (1=1)
					";
					
				

				$ChildItems = $db->getRecords($childsql);
				$icount=0;
				foreach ($ChildItems as $ChildItem) {
					if($ChildItems[$icount]['ID']===NULL)
						$ChildItems[$icount]['ID']=0;
					
					$ChildItems[$icount]['ParentID']=$ObservationsType['ID'];
					//$ChildItems[$icount]['CategoryID']=$ObservationsType['CategoryID'];
					//$ChildItems[$icount]['ObservationTypeID']=$ObservationsType['ObservationTypeID'];
					
					$icount++;
				}
				$ObservationsType['Replies']=$ChildItems;
				
				$imagesql = "select I.*  from Portal_ObservationImages I where ObservationID = ".$ObservationsType['ID'];
				$ObservationsType['ImageSet'] = array();
			

					$ImageData = $db->getRecords($imagesql);
					if($ImageData!=NULL)
					$ObservationsType['ImageSet']= $ImageData;
			
				$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationsType['where']."/%'";
				$funcgr = $db->getRecords($sql);
				if ($funcgr != NULL) {
					$funitems = array();
					foreach ($funcgr as $fun) {
						$funitems[] = $fun;
					}
					$ObservationsType['CircuitList']  = $funitems;
				}
				
				$Typeitems[] = $ObservationsType;
                                $ObservationsType['itemType'] = "GM";
                                $AllTypeitems[] = $ObservationsType;
			}
			
		}
		
		$ObservationRes['GMdata']  = $Typeitems;
		
		$sql = "select 
		O.ID,HotelID,CategoryID,StatusID,FundingID,ObservationTypeID,
				date_format(DiscoveredDate,'%Y-%m-%d') DiscoveredDate,`where`,what,
			Circuit,ShortDescription,Description,ActionRequired,SuccessCloseCriteria,
			date_format(DateHotelCompleted,'%Y-%m-%d')  DateHotelCompleted,
			 date_format(DateRpActioned,'%Y-%m-%d')  DateRpActioned,
			ValuePerAnnum,Calcs,
			CreatedDate,
			O.ParentID,PriorityNumber,
			ValuePerAnnumStatus_est,ValuePerAnnumStatus_upto,ValuePerAnnumStatus_tbd,ValuePerAnnumStatus_na
		, OT.Name ObservationTypeName, CT.Name CategoryName, ST.Name StatusName, FT.Name FundingName,c.Name whereName  ";
		
		if($session['isadmin']!=1)
			$sql .=" , ifnull(InDropdown,0) InDropdown, ifnull(InView,0) InView, ifnull(CanEdit,0) CanEdit	";
		else
			$sql .=" , 1 InDropdown,1 InView, 1 CanEdit		";
		
		$sql .="
		from Portal_OBS O 
			JOIN Portal_ObservationsType OT
			ON (O.ObservationTypeID=OT.ID) 
			JOIN Portal_ObservationCategory CT
			ON (O.CategoryID=CT.ID) 
			JOIN Portal_ObservationStatus ST
			ON (O.StatusID=ST.ID)
			JOIN Portal_ObservationFunding FT
			ON (O.FundingID=FT.ID)	
			JOIN creat072_vue.channel c 
			ON (O.`where` = c.GroupID) ";
			
			if($session['isadmin']!=1)
			$sql .="	
			JOIN 
				(
					select distinct RO.* from 
						(select * from Portal_Users where ID=".$session['uid'].") U
					join Portal_UserTitle UT
					on (U.Title = UT.ID)
					join Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID and UR.Active=1)
					join Portal_RolesToObservationStatus RO
					on (UR.RoleID = RO.RoleID)
				) URO
			on (ST.ID = URO.ObservationStatusID)";
			
			$sql .="
			where ";
			
			if($session['isadmin']!=1)
			$sql .="	URO.InView=1 AND exists ("
                                . "select * from 
						(select * from Portal_Users where ID=".$session['uid'].") U
					join Portal_UserTitle UT
					on (U.Title = UT.ID)
					join Portal_UserTitleToRoles UR
					on (UT.ID = UR.UserTitleID and UR.Active=1)
                                        join Portal_Roles R
                                        ON (UR.RoleID= R.ID)
                                        JOIN Portal_RolesToPermissions RP
                                        ON (R.ID = RP.RoleiD)
                                        JOIN Portal_Permissions P
                                        ON (RP.PermissionID = P.ID)
                                        where P.Name like concat('ObservationWhere_',c.Name) and RP.Active=1) AND ";
		
			$sql .="
			O.ObservationTypeID=1 
			AND O.ParentID IS NULL AND O.HotelID=".$r->dparams->SelectedHotel;
			
		

		$ObservationsTypes = $db->getRecords($sql);
		$Typeitems = array();
		if ($ObservationsTypes != NULL) {

			
			
			foreach ($ObservationsTypes as $ObservationsType) {

				$childsql = "select O.*, concat(U.Firstname,' ',U.Lastname) UserName from 
					Portal_OBS O left join Portal_Users U on (O.UserID=U.ID) where O.ParentID =".$ObservationsType['ID']." 
                    union all
                    select k.*,'' k from 
					(	select * from 
						Portal_OBS where 1=2
					) k right join (select 1 num ) t ON (1=1)
					";
					
				

				$ChildItems = $db->getRecords($childsql);
				$icount=0;
				foreach ($ChildItems as $ChildItem) {
					if($ChildItems[$icount]['ID']===NULL)
						$ChildItems[$icount]['ID']=0;
					
					$ChildItems[$icount]['ParentID']=$ObservationsType['ID'];
					
					$icount++;
				}
				$ObservationsType['Replies']=$ChildItems;
				
				$imagesql = "select I.*  from Portal_ObservationImages I where ObservationID = ".$ObservationsType['ID'];
				$ObservationsType['ImageSet'] = array();
			

					$ImageData = $db->getRecords($imagesql);
					if($ImageData!=NULL)
					$ObservationsType['ImageSet']= $ImageData;
				
				$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationsType['where']."/%'";
				$funcgr = $db->getRecords($sql);
				if ($funcgr != NULL) {
					$funitems = array();
					foreach ($funcgr as $fun) {
						$funitems[] = $fun;
					}
					$ObservationsType['CircuitList']  = $funitems;
				}
				
				$Typeitems[] = $ObservationsType;
                                $ObservationsType['itemType'] = "OBS";
                                $AllTypeitems[] = $ObservationsType;
			}
			
		}
		
		$ObservationRes['OBSdata']  = $Typeitems;
                $ObservationRes['AllOBSdata']  = $AllTypeitems;
		
		
		$sql = "select *  from Portal_ObservationsType ";
			
		

		$ObservationsTypes = $db->getRecords($sql);
		if ($ObservationsTypes != NULL) {

			
			$Typeitems = array();
			foreach ($ObservationsTypes as $ObservationsType) {

				$Typeitems[] = $ObservationsType;
			}
			$ObservationRes['Types']  = $Typeitems;
		}
		
		$sql = "select distinct GroupId, name Name  from creat072_vue.channel where parentid= ".$r->dparams->SelectedHotel;
		$funcgr = $db->getRecords($sql);
		if ($funcgr != NULL) {
			$funitems = array();
			foreach ($funcgr as $fun) {
				$funitems[] = $fun;
			}
			$ObservationRes['FuntionalGroups']  = $funitems;
			
			$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationRes['FuntionalGroups'][0]['GroupId']."/%'";
			$funcgr = $db->getRecords($sql);
			if ($funcgr != NULL) {
				$funitems = array();
				foreach ($funcgr as $fun) {
					$funitems[] = $fun;
				}
				$ObservationRes['FuntionalGroupsCircuits']  = $funitems;
			}
		}
		
		
		
		$sql = "select *  from Portal_ObservationCategory ";
		$catrgories = $db->getRecords($sql);
		if ($catrgories != NULL) {
			$catitems = array();
			foreach ($catrgories as $catrgorie) {
				$catitems[] = $catrgorie;
			}
			$ObservationRes['Categories']  = $catitems;
		}
		
		//$session['uid'];
		
		//"select distinct ObservationStatusID from Portal_RolesToObservationStatus RS where RoleID IN (select R.ID from Portal_User U join Portal_UserTitleToRoles UT on (U.Title = UT.UserTitleID) join Portal_Roles R on (UT.RoleID = R.ID ) where U.id=".$session['uid'].")" 
		if($session['isadmin']==1)
			$sql = "select *  from Portal_ObservationStatus";
		else
			$sql = "select *  from Portal_ObservationStatus where ID in (select distinct ObservationStatusID from Portal_RolesToObservationStatus RS where InDropdown=1 AND  RoleID IN (select R.ID from Portal_Users U join Portal_UserTitleToRoles UT on (U.Title = UT.UserTitleID) join Portal_Roles R on (UT.RoleID = R.ID ) where U.id=".$session['uid']."))";
		
		
		$Statuses = $db->getRecords($sql);
		
		if ($Statuses == NULL) {
			$sql = "select *  from Portal_ObservationStatus";
			$Statuses = $db->getRecords($sql);
		}
		
		
		if ($Statuses != NULL) {
			$statitems = array();
			foreach ($Statuses as $Status) {
				$statitems[] = $Status;
			}
			$ObservationRes['Status']  = $statitems;
		}
		
		$sql = "select *  from Portal_ObservationFunding ";
		$fundings = $db->getRecords($sql);
		if ($fundings != NULL) {
			$funditems = array();
			foreach ($fundings as $funding) {
				$funditems[] = $funding;
			}
			$ObservationRes['Funding']  = $funditems;
		}
			
			$response['OBSDetails']= $ObservationRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/LoadOBSDetails', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	$ObservationRes = null;
	{ // Load channel
	 


					$sql = "select  
							O.ID,HotelID,CategoryID,StatusID,FundingID,ObservationTypeID,
							date_format(DiscoveredDate,'%Y-%m-%d') DiscoveredDate,`where`,what,
						Circuit,ShortDescription,Description,ActionRequired,SuccessCloseCriteria,
						date_format(DateHotelCompleted,'%Y-%m-%d')  DateHotelCompleted,
						 date_format(DateRpActioned,'%Y-%m-%d')  DateRpActioned,
						ValuePerAnnum,Calcs,
						CreatedDate,
						O.ParentID,PriorityNumber, OT.Code itemType

						, O.flag5k, 
						ValuePerAnnumStatus_est,ValuePerAnnumStatus_upto,ValuePerAnnumStatus_tbd,ValuePerAnnumStatus_na,
						OT.Name ObservationTypeName, CT.Name CategoryName, ST.Name StatusName, FT.Name FundingName, c.Name whereName  ";
					
					if($session['isadmin']!="1")
						$sql .=" , ifnull(InDropdown,0) InDropdown, ifnull(InView,0) InView, ifnull(CanEdit,0) CanEdit	";
					else
						$sql .=" , 1 InDropdown,1 InView, 1 CanEdit		";
					
					$sql .="from Portal_OBS O 
						JOIN Portal_ObservationsType OT
						ON (O.ObservationTypeID=OT.ID) 
						JOIN Portal_ObservationCategory CT
						ON (O.CategoryID=CT.ID) 
						JOIN Portal_ObservationStatus ST
						ON (O.StatusID=ST.ID)
						JOIN Portal_ObservationFunding FT
						ON (O.FundingID=FT.ID)	
						JOIN creat072_vue.channel c 
						ON (O.`where` = c.GroupID) ";

						if($session['isadmin']!="1")
						$sql .="	
						JOIN 
							(
								select distinct RO.* from 
									(select * from Portal_Users where ID=".$session['uid'].") U
								join Portal_UserTitle UT
								on (U.Title = UT.ID)
								join Portal_UserTitleToRoles UR
								on (UT.ID = UR.UserTitleID and UR.Active=1)
								join Portal_RolesToObservationStatus RO
								on (UR.RoleID = RO.RoleID)
							) URO
						on (ST.ID = URO.ObservationStatusID)";
						
						$sql .="
						where ";
						
						if($session['isadmin']!="1")
						$sql .="	URO.InView=1 AND exists ("
			                                . "select * from 
									(select * from Portal_Users where ID=".$session['uid'].") U
								join Portal_UserTitle UT
								on (U.Title = UT.ID)
								join Portal_UserTitleToRoles UR
								on (UT.ID = UR.UserTitleID and UR.Active=1)
			                                        join Portal_Roles R
			                                        ON (UR.RoleID= R.ID)
			                                        JOIN Portal_RolesToPermissions RP
			                                        ON (R.ID = RP.RoleiD)
			                                        JOIN Portal_Permissions P
			                                        ON (RP.PermissionID = P.ID)
			                                        where P.Name like concat('ObservationWhere_',c.Name)  and RP.Active=1) AND ";
					
						$sql .=" O.ParentID IS NULL and (flag5k=".$r->dparams->flag5k." OR 0=".$r->dparams->flag5k.") and ifnull(O.Deleted,0)=0 AND O.HotelID=".$r->dparams->SelectedHotel;
						

					
					//echo $sql ;
					
					$ObservationsTypes = $db->getRecords($sql);
					$Typeitems = array();
			         $mcount=0;       
					if ($ObservationsTypes != NULL) {

						
						
						foreach ($ObservationsTypes as $ObservationsType) {

								$childsql = "select O.*, concat(U.Firstname,' ',U.Lastname) UserName, ST.Name StatusName from 
								Portal_OBS O
								JOIN Portal_ObservationStatus ST
						ON (O.StatusID=ST.ID)
								 left join Portal_Users U on (O.UserID=U.ID) where O.ParentID =".$ObservationsType['ID']." 
			                    union all
			                    select k.*,'' k,'' t from 
								(	select * from 
									Portal_OBS where 1=2
								) k right join (select 1 num ) t ON (1=1)
								";
								
							
									//echo $childsql;
							$ChildItems = $db->getRecords($childsql);
							$icount=0;
							foreach ($ChildItems as $ChildItem) {
								if($ChildItems[$icount]['ID']===NULL)
									$ChildItems[$icount]['ID']=0;
								
								$ChildItems[$icount]['ParentID']=$ObservationsType['ID'];
								
								

								$icount++;
							}
								


							$ObservationsTypes[$mcount]['Replies']=$ChildItems;
							
							$imagesql = "select I.*  from Portal_ObservationImages I where ObservationID = ".$ObservationsType['ID'];
							$ObservationsTypes[$mcount]['ImageSet'] = array();
						

								$ImageData = $db->getRecords($imagesql);
								if($ImageData!=NULL)
								$ObservationsTypes[$mcount]['ImageSet']= $ImageData;
						
							$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationsType['where']."/%'";
							$funcgr = $db->getRecords($sql);
							if ($funcgr != NULL) {
								$funitems = array();
								foreach ($funcgr as $fun) {
									$funitems[] = $fun;
								}
								$ObservationsTypes[$mcount]['CircuitList']  = $funitems;
							}
							
							//$Typeitems[] = $ObservationsType;
			                                //$ObservationsType['itemType'] = $SMType['Code'];
			                                //$AllTypeitems[] = $ObservationsType;

			                          $mcount++;      
						}
						
					}
					
					//$ObservationRes[$SMType['Code'].'data']  = $Typeitems;

		
	

		
		
		

                $ObservationRes['AllOBSdata']  = $ObservationsTypes;
		
		$sql = "select *  from Portal_ObservationsType ";
			
		

		$ObservationsTypes = $db->getRecords($sql);
		if ($ObservationsTypes != NULL) {

			
			$Typeitems = array();
			foreach ($ObservationsTypes as $ObservationsType) {

				$Typeitems[] = $ObservationsType;
			}
			$ObservationRes['Types']  = $Typeitems;
		}
		
		$sql = "select distinct GroupId, name Name  from creat072_vue.channel where parentid= ".$r->dparams->SelectedHotel;
		$funcgr = $db->getRecords($sql);
		if ($funcgr != NULL) {
			$funitems = array();
			foreach ($funcgr as $fun) {
				$funitems[] = $fun;
			}
			$ObservationRes['FuntionalGroups']  = $funitems;
			
			$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationRes['FuntionalGroups'][0]['GroupId']."/%'";
			$funcgr = $db->getRecords($sql);
			if ($funcgr != NULL) {
				$funitems = array();
				foreach ($funcgr as $fun) {
					$funitems[] = $fun;
				}
				$ObservationRes['FuntionalGroupsCircuits']  = $funitems;
			}
		}
		
		
		
		$sql = "select *  from Portal_ObservationCategory ";
		$catrgories = $db->getRecords($sql);
		if ($catrgories != NULL) {
			$catitems = array();
			foreach ($catrgories as $catrgorie) {
				$catitems[] = $catrgorie;
			}
			$ObservationRes['Categories']  = $catitems;
		}
		
		//$session['uid'];
		
		//"select distinct ObservationStatusID from Portal_RolesToObservationStatus RS where RoleID IN (select R.ID from Portal_User U join Portal_UserTitleToRoles UT on (U.Title = UT.UserTitleID) join Portal_Roles R on (UT.RoleID = R.ID ) where U.id=".$session['uid'].")" 
		if($session['isadmin']==1)
			$sql = "select *  from Portal_ObservationStatus";
		else
			$sql = "select *  from Portal_ObservationStatus where ID in (select distinct ObservationStatusID from Portal_RolesToObservationStatus RS where InDropdown=1 AND  RoleID IN (select R.ID from Portal_Users U join Portal_UserTitleToRoles UT on (U.Title = UT.UserTitleID) join Portal_Roles R on (UT.RoleID = R.ID ) where U.id=".$session['uid']."))";
		
		
		$Statuses = $db->getRecords($sql);
		
		if ($Statuses == NULL) {
			$sql = "select *  from Portal_ObservationStatus";
			$Statuses = $db->getRecords($sql);
		}
		
		
		if ($Statuses != NULL) {
			$statitems = array();
			foreach ($Statuses as $Status) {
				$statitems[] = $Status;
			}
			$ObservationRes['Status']  = $statitems;
		}
		
		$sql = "select *  from Portal_ObservationFunding ";
		$fundings = $db->getRecords($sql);
		if ($fundings != NULL) {
			$funditems = array();
			foreach ($fundings as $funding) {
				$funditems[] = $funding;
			}
			$ObservationRes['Funding']  = $funditems;
		}
			
			$response['OBSDetails']= $ObservationRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/LoadOBSDetailsTobeDeleted1', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	$ObservationRes = null;
	{ // Load channel
	 

	 $AllTypeitems = array();
	 
		$SMTypes = $db->getRecords("SELECT * FROM Portal_ObservationsType");
		if($SMTypes!=null)
		{
			foreach ($SMTypes as $SMType) {

					$sql = "select  
							O.ID,HotelID,CategoryID,StatusID,FundingID,ObservationTypeID,
							date_format(DiscoveredDate,'%Y-%m-%d') DiscoveredDate,`where`,what,
						Circuit,ShortDescription,Description,ActionRequired,SuccessCloseCriteria,
						date_format(DateHotelCompleted,'%Y-%m-%d')  DateHotelCompleted,
						 date_format(DateRpActioned,'%Y-%m-%d')  DateRpActioned,
						ValuePerAnnum,Calcs,
						CreatedDate,
						O.ParentID,PriorityNumber

						, O.flag5k, 
						ValuePerAnnumStatus_est,ValuePerAnnumStatus_upto,ValuePerAnnumStatus_tbd,ValuePerAnnumStatus_na,
						OT.Name ObservationTypeName, CT.Name CategoryName, ST.Name StatusName, FT.Name FundingName, c.Name whereName  ";
					
					if($session['isadmin']!="1")
						$sql .=" , ifnull(InDropdown,0) InDropdown, ifnull(InView,0) InView, ifnull(CanEdit,0) CanEdit	";
					else
						$sql .=" , 1 InDropdown,1 InView, 1 CanEdit		";
					
					$sql .="from Portal_OBS O 
						JOIN Portal_ObservationsType OT
						ON (O.ObservationTypeID=OT.ID) 
						JOIN Portal_ObservationCategory CT
						ON (O.CategoryID=CT.ID) 
						JOIN Portal_ObservationStatus ST
						ON (O.StatusID=ST.ID)
						JOIN Portal_ObservationFunding FT
						ON (O.FundingID=FT.ID)	
						JOIN creat072_vue.channel c 
						ON (O.`where` = c.GroupID) ";

						if($session['isadmin']!="1")
						$sql .="	
						JOIN 
							(
								select distinct RO.* from 
									(select * from Portal_Users where ID=".$session['uid'].") U
								join Portal_UserTitle UT
								on (U.Title = UT.ID)
								join Portal_UserTitleToRoles UR
								on (UT.ID = UR.UserTitleID and UR.Active=1)
								join Portal_RolesToObservationStatus RO
								on (UR.RoleID = RO.RoleID)
							) URO
						on (ST.ID = URO.ObservationStatusID)";
						
						$sql .="
						where ";
						
						if($session['isadmin']!="1")
						$sql .="	URO.InView=1 AND exists ("
			                                . "select * from 
									(select * from Portal_Users where ID=".$session['uid'].") U
								join Portal_UserTitle UT
								on (U.Title = UT.ID)
								join Portal_UserTitleToRoles UR
								on (UT.ID = UR.UserTitleID and UR.Active=1)
			                                        join Portal_Roles R
			                                        ON (UR.RoleID= R.ID)
			                                        JOIN Portal_RolesToPermissions RP
			                                        ON (R.ID = RP.RoleiD)
			                                        JOIN Portal_Permissions P
			                                        ON (RP.PermissionID = P.ID)
			                                        where P.Name like concat('ObservationWhere_',c.Name)  and RP.Active=1) AND ";
					
						$sql .=" O.ObservationTypeID=".$SMType['ID']." AND O.ParentID IS NULL and (flag5k=".$r->dparams->flag5k." OR 0=".$r->dparams->flag5k.") and ifnull(O.Deleted,0)=0 AND O.HotelID=".$r->dparams->SelectedHotel;
						

					
					//echo $sql ;
					
					$ObservationsTypes = $db->getRecords($sql);
					$Typeitems = array();
			                
					if ($ObservationsTypes != NULL) {

						
						
						foreach ($ObservationsTypes as $ObservationsType) {

								$childsql = "select O.*, concat(U.Firstname,' ',U.Lastname) UserName, ST.Name StatusName from 
								Portal_OBS O
								JOIN Portal_ObservationStatus ST
						ON (O.StatusID=ST.ID)
								 left join Portal_Users U on (O.UserID=U.ID) where O.ParentID =".$ObservationsType['ID']." 
			                    union all
			                    select k.*,'' k,'' t from 
								(	select * from 
									Portal_OBS where 1=2
								) k right join (select 1 num ) t ON (1=1)
								";
								
							
									//echo $childsql;
							$ChildItems = $db->getRecords($childsql);
							$icount=0;
							foreach ($ChildItems as $ChildItem) {
								if($ChildItems[$icount]['ID']===NULL)
									$ChildItems[$icount]['ID']=0;
								
								$ChildItems[$icount]['ParentID']=$ObservationsType['ID'];
								
								

								$icount++;
							}
								


							$ObservationsType['Replies']=$ChildItems;
							
							$imagesql = "select I.*  from Portal_ObservationImages I where ObservationID = ".$ObservationsType['ID'];
							$ObservationsType['ImageSet'] = array();
						

								$ImageData = $db->getRecords($imagesql);
								if($ImageData!=NULL)
								$ObservationsType['ImageSet']= $ImageData;
						
							$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationsType['where']."/%'";
							$funcgr = $db->getRecords($sql);
							if ($funcgr != NULL) {
								$funitems = array();
								foreach ($funcgr as $fun) {
									$funitems[] = $fun;
								}
								$ObservationsType['CircuitList']  = $funitems;
							}
							
							$Typeitems[] = $ObservationsType;
			                                $ObservationsType['itemType'] = $SMType['Code'];
			                                $AllTypeitems[] = $ObservationsType;

			                                
						}
						
					}
					
					$ObservationRes[$SMType['Code'].'data']  = $Typeitems;

			}
		}

		
		
		

                $ObservationRes['AllOBSdata']  = $AllTypeitems;
		
		$sql = "select *  from Portal_ObservationsType ";
			
		

		$ObservationsTypes = $db->getRecords($sql);
		if ($ObservationsTypes != NULL) {

			
			$Typeitems = array();
			foreach ($ObservationsTypes as $ObservationsType) {

				$Typeitems[] = $ObservationsType;
			}
			$ObservationRes['Types']  = $Typeitems;
		}
		
		$sql = "select distinct GroupId, name Name  from creat072_vue.channel where parentid= ".$r->dparams->SelectedHotel;
		$funcgr = $db->getRecords($sql);
		if ($funcgr != NULL) {
			$funitems = array();
			foreach ($funcgr as $fun) {
				$funitems[] = $fun;
			}
			$ObservationRes['FuntionalGroups']  = $funitems;
			
			$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$ObservationRes['FuntionalGroups'][0]['GroupId']."/%'";
			$funcgr = $db->getRecords($sql);
			if ($funcgr != NULL) {
				$funitems = array();
				foreach ($funcgr as $fun) {
					$funitems[] = $fun;
				}
				$ObservationRes['FuntionalGroupsCircuits']  = $funitems;
			}
		}
		
		
		
		$sql = "select *  from Portal_ObservationCategory ";
		$catrgories = $db->getRecords($sql);
		if ($catrgories != NULL) {
			$catitems = array();
			foreach ($catrgories as $catrgorie) {
				$catitems[] = $catrgorie;
			}
			$ObservationRes['Categories']  = $catitems;
		}
		
		//$session['uid'];
		
		//"select distinct ObservationStatusID from Portal_RolesToObservationStatus RS where RoleID IN (select R.ID from Portal_User U join Portal_UserTitleToRoles UT on (U.Title = UT.UserTitleID) join Portal_Roles R on (UT.RoleID = R.ID ) where U.id=".$session['uid'].")" 
		if($session['isadmin']==1)
			$sql = "select *  from Portal_ObservationStatus";
		else
			$sql = "select *  from Portal_ObservationStatus where ID in (select distinct ObservationStatusID from Portal_RolesToObservationStatus RS where InDropdown=1 AND  RoleID IN (select R.ID from Portal_Users U join Portal_UserTitleToRoles UT on (U.Title = UT.UserTitleID) join Portal_Roles R on (UT.RoleID = R.ID ) where U.id=".$session['uid']."))";
		
		
		$Statuses = $db->getRecords($sql);
		
		if ($Statuses == NULL) {
			$sql = "select *  from Portal_ObservationStatus";
			$Statuses = $db->getRecords($sql);
		}
		
		
		if ($Statuses != NULL) {
			$statitems = array();
			foreach ($Statuses as $Status) {
				$statitems[] = $Status;
			}
			$ObservationRes['Status']  = $statitems;
		}
		
		$sql = "select *  from Portal_ObservationFunding ";
		$fundings = $db->getRecords($sql);
		if ($fundings != NULL) {
			$funditems = array();
			foreach ($fundings as $funding) {
				$funditems[] = $funding;
			}
			$ObservationRes['Funding']  = $funditems;
		}
			
			$response['OBSDetails']= $ObservationRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/SaveOBSReplyChanges', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
			

		if($r->dparams->ID>0)
		{
			$sql = "Update Portal_OBS set ";
			$sql .= "HotelID = '".$r->dparams->HotelID."' ,";
			$sql .= "ObservationTypeID = '".$r->dparams->ObservationTypeID."' ,";
			$sql .= "CategoryID = '".$r->dparams->CategoryID."' ,";
			$sql .= "StatusID = '".$r->dparams->StatusID."' ,";
			$sql .= "FundingID = '".$r->dparams->FundingID."' ,";
			$sql .= "DiscoveredDate = '".$r->dparams->DiscoveredDate."' ,";
			$sql .= "`where` = '".$r->dparams->where."' ,";
			$sql .= "what = '".$r->dparams->what."' ,";
			$sql .= "Circuit = '".$r->dparams->Circuit."' ,";
			$sql .= "ShortDescription = '".addslashes($r->dparams->ShortDescription)."' , ";
			$sql .= "Description = '".addslashes($r->dparams->Description)."' , ";
			$sql .= "ActionRequired = '".addslashes($r->dparams->ActionRequired)."' , ";
			$sql .= "SuccessCloseCriteria = '".addslashes($r->dparams->SuccessCloseCriteria)."' , ";
			$sql .= "DateHotelCompleted = '".$r->dparams->DateHotelCompleted."' , ";
			$sql .= "DateRpActioned = '".$r->dparams->DateRpActioned."' , ";
			$sql .= "ValuePerAnnum = '".$r->dparams->ValuePerAnnum."' , ";
			$sql .= "ParentID = '".$r->dparams->ParentID."' , ";
			$sql .= "Calcs = '".$r->dparams->Calcs."' ,  ";
                        $sql .= "HotelResponse = '".addslashes($r->dparams->HotelResponse)."'   ";
			$sql .= " where ID = '".$r->dparams->ID."' ";
			//echo $sql;
				$result = $db->executeSQL($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation updated successfully";
					$response["ID"] = $r->dparams->ID;
					$db->writeLog($session['uid'],"Modified an observation response of RefID:".$r->dparams->ParentID,$r->dparams->HotelID,'ObservationResponse');
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update Observation . Please try again";
					
				}   
		}
		else
		{



				
				$sql = "insert into Portal_OBS  (UserID,HotelID,ObservationTypeID,CategoryID,StatusID,FundingID, DiscoveredDate,`where`, what, Circuit, ShortDescription, Description,ActionRequired,SuccessCloseCriteria,DateHotelCompleted,DateRpActioned,ValuePerAnnum,Calcs,ParentID, HotelResponse, CreatedDate) values (";
                                $sql .= $session['uid'].", ";
				$sql .= "'".$r->dparams->HotelID."', ";
				$sql .= "'".$r->dparams->ObservationTypeID."', ";
				$sql .= "'".$r->dparams->CategoryID."', ";
				$sql .= "'".$r->dparams->StatusID."', ";
				$sql .= "'".$r->dparams->FundingID."', ";
				$sql .= "'".$r->dparams->DiscoveredDate."', ";
				$sql .= "'".$r->dparams->where."' , ";
				$sql .= "'".$r->dparams->what."' , ";
				$sql .= "'".$r->dparams->Circuit."' ,";
				$sql .= "'".addslashes($r->dparams->ShortDescription)."' ,";
				$sql .= "'".addslashes($r->dparams->Description)."' ,";
				$sql .= "'".addslashes($r->dparams->ActionRequired)."' ,";
				$sql .= "'".addslashes($r->dparams->SuccessCloseCriteria)."' ,";
				$sql .= "'".$r->dparams->DateHotelCompleted."' ,";
				$sql .= "'".$r->dparams->DateRpActioned."' ,";
				$sql .= "'".$r->dparams->ValuePerAnnum."' ,";
				$sql .= "'".$r->dparams->Calcs."' , ";
				$sql .= "'".$r->dparams->ParentID."' , ";
                                $sql .= "'".addslashes($r->dparams->HotelResponse)."' , ";
                                
				$sql .= "now())";
			//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Observation details added successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					$db->writeLog($session['uid'],"Added a new observation response to RefID:".$r->dparams->ParentID,$r->dparams->HotelID,'ObservationResponse');
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add Observation details. Please try again";
					
				}   

		}
		
		//Update the parent with the new status
		$sql = "update Portal_OBS set StatusID = '".$r->dparams->StatusID."' where id=".$r->dparams->ParentID;
		$db->executeSQL($sql);
		
                $childsql = "select O.*, concat(U.Firstname,' ',U.Lastname) UserName from 
					Portal_OBS O left join Portal_Users U on (O.UserID=U.ID) where O.ParentID =".$r->dparams->ParentID." 
                    union all
                    select k.*,'' k from 
                    
		
					(	select * from 
						Portal_OBS where 1=2
					) k right join (select 1 num ) t ON (1=1)
					";
					
				
				

				$ChildItems = $db->getRecords($childsql);
				$icount=0;
				foreach ($ChildItems as $ChildItem) {
					if($ChildItems[$icount]['ID']===NULL)
						$ChildItems[$icount]['ID']=0;
					
					
					
					$icount++;
				}
				$response['Replies']=$ChildItems;
		
				
	
	
	
	
    echoResponse(200, $response);
	
});


$app->post('/WriteLog', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	
	$db->writeLog($session['uid'],$r->dparams->Description,$r->dparams->SelectedHotel,$r->dparams->WidgetName);
	$response["status"] = "success";
	$response["message"] = "Log written";		
    echoResponse(200, $response);
	
});


$app->post('/LoadLogActivityDetails', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	 
	 		$extra = "H.groupid in (select HotelID from Portal_UserToHotels where UserID = ".$session['uid'].") and ";
	 		if($session['isadmin']=="1")
	 		{
	 			$extra="";
	 		}

			$sql = "select L.*,U.Username, H.Name HotelName  from Portal_Logs L 
			JOIN Portal_Users U ON (L.UserID = U.ID)
			LEFT JOIN (select groupid , Name from creat072_vue.channel where parentid=1) H ON (L.HotelID= H.groupid)
			where 
			U.ID not in (1,17,24,61,74,87,113,26,66,170,261,85,436,440, ".$session['uid'].") and 
			".$extra."  
			L.CreatedDate between '".$r->dparams->StartDate."' and date_add('".$r->dparams->EndDate."', interval 1 day) 
			and (H.groupid = ".$r->dparams->SelectedHotel." OR ".$r->dparams->SelectedHotel." = 0)
			Order by L.CreatedDate desc
			";
			
		//echo $sql;

		$LogAct = $db->getRecords($sql);
		if ($LogAct != NULL) {

			$LogRes['status'] = "success";
			$LogRes['message'] = 'Loaded Successfully';

			
			$LogRes['Data']  = $LogAct;
			$dateDetails = $db->getOneRecord("select '".$r->dparams->StartDate."' startdate , '".$r->dparams->EndDate."' enddate");

			$chartQuery = "select * from ( select 
				date_format(CreatedDate,'%Y-%m-%d') date, 
				WidgetName Name, 
				replace(WidgetName,' ', '') wname,
				count(*) cnt 
				from Portal_Logs where 
				WidgetName is not NULL
				and UserID not in (1,17,24,61,74,87,113,26,66,170,261,85,436,440,".$session['uid'].")
				and (HotelID = ".$r->dparams->SelectedHotel." OR ".$r->dparams->SelectedHotel." = 0)
				and CreatedDate between '".$r->dparams->StartDate."' and date_add('".$r->dparams->EndDate."', interval 1 day)  
				and WidgetName is not null and  ltrim(WidgetName)<>'' 
				group by date_format(CreatedDate,'%Y-%m-%d'), WidgetName 
				) k order by k.date desc";
				//echo $chartQuery;
				//die();
			$LogCharts = $db->getRecords($chartQuery);
			//print_r($LogCharts);
			$chartCategory = array();
			$seriesCategory = array();
			$chartCategory= array();
			$theDates = array();
			//array_reverse($OccupancyDetails)
			foreach (array_reverse($LogCharts) as $item) {

					$vt=$item['wname'];
					$seriesCategory[$vt] = (!array_key_exists($vt, $seriesCategory)?'':$seriesCategory[$vt])."";

					
				}

				foreach (array_reverse($LogCharts) as $item) {
					
					if(!in_array($item['date'], $theDates))
					$theDates[]=$item['date'];
				}
				foreach (array_reverse($LogCharts) as $item) {
					
					if(!in_array("'".$item['date']."'", $chartCategory))
					$chartCategory[]="'".$item['date']."'";
				}

$found=false;
foreach ($theDates as $tem) {
	$found=false;
				foreach ($seriesCategory as $key => $value) {

						//echo $key."<br>";
						
								
							//echo $tem."<br>";
						$found=false;
							foreach (array_reverse($LogCharts) as $item) {
								$vt=$item['wname'];
								if($vt==$key)
								{
									

									if($tem == $item['date'])
									{
										$found=true;
										//echo $item['date'].":".$key.":".$item['cnt']."<br/>";
										$seriesCategory[$key] = $seriesCategory[$key].$item['cnt'].",";
									}
								    //else if()
								    //{
								    //	echo $item['date'].":".$key.":"."0"."<br/>";
									//	$seriesCategory[$key] = $seriesCategory[$key]."0,";
									//}
								}
								else
								{
									//echo $tem.":".$vt.":"."0"."<br/>";
									//$seriesCategory[$vt] = $seriesCategory[$vt]."0,";
								}
							}

							if(!$found)
							{
								//echo $tem.":".$key.":0<br/>";
								$seriesCategory[$key] = $seriesCategory[$key]."0,";
							}
						}
					}


			/*foreach (array_reverse($LogCharts) as $item) {
					
					
					$vt=$item['wname'];
					//$vt=$item['Name']."_".$item['wname'];
					foreach ($seriesCategory as $key => $value) {

						if($key == $vt)
							$seriesCategory[$vt] = (!array_key_exists($vt, $seriesCategory)?'':$seriesCategory[$vt]).$item['cnt'].",";
						else
						{
							//if(!array_key_exists($item['date'], $theDates))
							$seriesCategory[$vt] = (!array_key_exists($vt, $seriesCategory)?'':$seriesCategory[$vt])."0,";
						}
					}

				}*/
//print_r($theDates);
				//print_r($seriesCategory);
				//print_r($chartCategory);

				/*
			$LogActivityChartString = "{
				chart: {
					renderTo: 'LogActivityChart',
					type: 'column'
				},
				
				title: {
					text: 'Log information from ".$dateDetails['startdate']." to ".$dateDetails['enddate']."'
				},
				xAxis: {
					categories: [".implode(",",$chartCategory)."]
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Number of'
					},
					stackLabels: {
						enabled: true,
						style: {
							fontWeight: 'bold',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
						}
					}
				},
				legend: {
					align: 'right',
					x: -30,
					enabled: false,
					verticalAlign: 'top',
					y: 25,
					floating: true,
					backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
					borderColor: '#CCC',
					borderWidth: 1,
					shadow: false
				},
				tooltip: {
					headerFormat: '<b>{point.x}</b><br/>',
					pointFormat: 'Total: {point.stackTotal}'
				},
				plotOptions: {
					column: {
						stacking: 'normal',
						dataLabels: {
							enabled: true,
							color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
							style: {
								textShadow: '0 0 3px black'
							}
						}
					}
				},
				series: [";
		$seriesstring = "";
		foreach($seriesCategory as $x => $x_value) {
			$seriesstring.="{name: '".$x."',data: [".rtrim($x_value, ',')."]},";
		}
		$seriesstring = rtrim($seriesstring, ',');
		$LogActivityChartString.=$seriesstring;
			
		$LogActivityChartString.="
				]
			}";
			//echo $LogActivityChartString;
			//die();

			*/

			$LogActivityChartString = "{
						chart: {
							renderTo: 'LogActivityChart',
							type: 'column'
						},
						
						title: {
							text: 'Log Chart'
						},
						xAxis: {
							categories: [".implode(",",$chartCategory)."]
						},
						yAxis: {
							min: 0,
							title: {
								text: 'Count'
							},
							stackLabels: {
								enabled: false,
								rotation: -90,
									 y: -25,
								style: {
									fontWeight: 'bold',
									color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
								}
							}
						},
						legend: {
							align: 'right',
							x: -30,
							verticalAlign: 'top',
							y: 25,
							floating: true,
							backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
							borderColor: '#CCC',
							borderWidth: 1,
							shadow: false
						},
						tooltip: {
							headerFormat: '<b>{series.options.stack}</b><br/>',
							pointFormat: 'Total: {point.stackTotal}'
						},
						plotOptions: {
							column: {
								stacking: 'normal',
								dataLabels: {
									enabled: false,
									
									color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
									style: {
										textShadow: '0 0 3px black'
									}
								}
							}
						},
						series: [";
				$seriesstring = "";
				$cate =   array();
				$colindex=-1;
				foreach($seriesCategory as $x => $x_value) {
					$str = explode("_",$x);
					$str[1] = $x;
					//$str = $x;
					$idstr = "";
					if(!array_key_exists($str[0], $cate))
					{
						$idstr = "id: '".$str[0]."'";
						$cate[$str[0]] = 1;
					}
					else
					{
						$keys = array_keys($cate);
						$index = array_search($str[0],$keys);
						$idstr = "color: Highcharts.getOptions().colors[".$index."], linkedTo: '".$str[0]."'";
					}
						
					$seriesstring.="{name: '".$str[0]."' , $idstr ,data: [".rtrim($x_value, ',')."], stack: '".$str[1]."'},";
				}
				//echo "$seriesstring";
				$seriesstring = rtrim($seriesstring, ',');
				$LogActivityChartString.=$seriesstring;
					
				$LogActivityChartString.="
						]
					}";
					

			$LogRes['LogChart']  = $LogActivityChartString;
			
		}
		else {
				$LogRes['status'] = "error";
				$LogRes['message'] = 'No Data found';
				$LogRes['Data'] = [];
			}

		
			
			$response['LogActivityDetails']= $LogRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/LoadCircuitsForFG', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	 

			$sql = "select -1 GroupId, 'All' Name union select distinct GroupId, Name  from creat072_vue.channelext where path like '%/".$r->dparams->FunctionalGroupID."/%'";
			
			

		$LogAct = $db->getRecords($sql);
		if ($LogAct != NULL) {

			$LogRes['status'] = "success";
			$LogRes['message'] = 'Loaded Successfully';

			
			$LogRes['Data']  = $LogAct;
		}
		else {
				$LogRes['status'] = "error";
				$LogRes['message'] = 'No such user is registered';
				$LogRes['Data'] = null;
			}

		
			
			$response['CircuitDetails']= $LogRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/SaveContactFormMessage', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();

				
				$sql = "insert into Portal_ContactFormMessages  (UserID,RoleID,HotelID, Subject,Message,CreatedDate,Viewed) values (";
                                $sql .= $session['uid'].", ";
                                $sql .= "'".$r->dparams->RoleID."', ";
                $sql .= "'".$r->dparams->HotelID."', ";
				$sql .= "'".$r->dparams->Subject."', ";
				$sql .= "'".$r->dparams->Message."', ";
				$sql .= "now(), ";
				$sql .= "'');";
			//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Message saved and sent";
					
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to send and save Message ";
					
				}   

		
		
                
	
	
	
    echoResponse(200, $response);
	
});


$app->post('/EmailHtml', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	 
		 

		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output

		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'mail.ukearth.co.uk';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'portal@ukearth.co.uk';                 // SMTP username
		$mail->Password = 'mortal-portal';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		$mail->setFrom('portal@ukearth.co.uk', 'Awesome Power');
		//$mail->addAddress('kandynote@gmail.com', 'kandynote');     // Add a recipient
		$mail->addAddress($session['email'], $session['name']);
		
		//$mail->addAddress('ellen@example.com');               // Name is optional
		//$mail->addReplyTo('info@example.com', 'Information');
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML

		$mail->Subject = 'Weather table';
		//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		$mail->Body    = $r->dparams->EmailContent;
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if(!$mail->send()) {
			//echo 'Message could not be sent.';
			//echo 'Mailer Error: ' . $mail->ErrorInfo;
			$LogRes['status'] = "error";
			$LogRes['message'] = $mail->ErrorInfo;
		} else {
			//echo 'Message has been sent';
				$LogRes['status'] = "success";
				$LogRes['message'] = 'Message has been sent';
		
		}
	 
			//echo $r->dparams->EmailContent;
			//	$LogRes['status'] = "success";
			//	$LogRes['message'] = 'Emailed';
				//$LogRes['Data'] = null;
			

		
			
			$response['data']= $LogRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});



$app->post('/LoadSMDataBarChart', function() use ($app)  
{
	 $r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	//print_r($r->dparams);
	//echo $r->dparams->WeatherEndDate;
	//echo $r->dparams->WeatherStartDate;
	//die();

	{ // Load weather
		
		/*
		$sql = "select 
						M.*,
						ifnull(SM.fb,0) fb,
						ifnull(SM.cb,0) cb,
						ifnull(SM.hf,0) hf,
						ifnull(SM.hk,0) hk,
						ifnull(SM.plant,0) plant,
						ifnull(SM.General,0) General,
						date_format(M.date, '%d-%m') date1
					from
					(
						select ".$r->dparams->SelectedHotel." hotelid, date_format(now(),'%Y-%m-%d') date
						union
						select ".$r->dparams->SelectedHotel." hotelid, date_format(date_add(now(), interval -1 week),'%Y-%m-%d') date
						union
						select ".$r->dparams->SelectedHotel." hotelid, date_format(date_add(now(), interval -1 year),'%Y-%m-%d') date
						
					) M
					left join smdata SM
					on (M.hotelid=SM.hotelid and M.date=SM.date)

				";
		
		*/
		/*if($session['isadmin']=="1")
		{
			$sql = "		select pk, date_format(date, '%Y-%m-%d') date, date_format(date, '%d-%m') date1,covers, rooms, functions, delegates, spa, sleepers, hotel, hotelid
							from mddailynewHO c
							
							where 
							  c.date between '".$r->dparams->OccupancyStartDate."' and '".$r->dparams->OccupancyEndDate."' and  hotelid = ".$r->dparams->SelectedHotel." 
							 order by hotel, date desc
							";
		}
		else
		{
		
			$sql = "		select c.pk, date_format(date, '%Y-%m-%d') date, date_format(date, '%d-%m') date1,covers, rooms, functions, delegates, spa, sleepers, hotel, c.hotelid
							from mddailynewHO c
							join Portal_UserToHotels n
							on (c.hotelid=n.HotelID)
							where 
							n.UserID=".$session['uid']." and  c.date between '".$r->dparams->OccupancyStartDate."' and '".$r->dparams->OccupancyEndDate."' 
							and c.hotelid = ".$r->dparams->SelectedHotel." 
							 order by hotel , date  desc
							";
		}
		*/
		{
			$sql = "

					select 
											M.*,
											ifnull(SM.fb,0) 'F&B',
											ifnull(SM.cb,0) 'C&B',
										ifnull(SM.hf,0) 'H&F',
										ifnull(SM.hk,0) 'House Keeping',
										ifnull(SM.plant,0) Plant,
										ifnull(SM.General,0) General
                       
						
											
										from
										(
											select hotelid , date as rdate, date_format(date,'%d-%m-%Y') date, date adate, 1 type, 'Current' typeName from smdata	where date between '".$r->dparams->StartDate."' and '".$r->dparams->EndDate."' and hotelid=".$r->dparams->SelectedHotel;
		if($r->dparams->LastWeek)
         $sql.="
                                            union all
                                            select hotelid, date as rdate ,date_format(date,'%d-%m-%Y') date, date_add(date, interval -1 week) adate,  2 type, 'Last Week' typeName from smdata	where date between '".$r->dparams->StartDate."' and '".$r->dparams->EndDate."' and hotelid=".$r->dparams->SelectedHotel  ;
         if($r->dparams->LastYear)
         $sql.="
                                            union all
                                            select hotelid, date as rdate ,date_format(date,'%d-%m-%Y') date, date_add(date, interval -1 year) adate,  3 type, 'Last Year' typeName from smdata	where date between '".$r->dparams->StartDate."' and '".$r->dparams->EndDate."' and hotelid=".$r->dparams->SelectedHotel;

         $sql.="
											
											
										) M
										left join smdata SM
										on (M.hotelid=SM.hotelid and (M.adate=SM.date ))
                                        

							
										order by M.rdate desc, M.type

				";
			//echo $sql;
			$OccupancyDetails = $db->getRecords($sql);
			$Occupancyitems = array();
			$chartCategory =   array();
			$seriesCategory =   array();
				
			$Occupancy['status'] = "success";
			$Occupancy['message'] = 'Logged in successfully.';
			$Occupancy['data'] = array();
				
			if ($OccupancyDetails != NULL) {

				$Occupancy['status'] = "success";
				$Occupancy['message'] = 'Logged in successfully.';
				
				foreach ($OccupancyDetails as $OccupancyDetail) {
					
				
					$Occupancyitems[] = $OccupancyDetail;
				}
				
				foreach (array_reverse($OccupancyDetails) as $OccupancyDetail) {
					
					if(!in_array("'".$OccupancyDetail['date']."'", $chartCategory))
					$chartCategory[]="'".$OccupancyDetail['date']."'";
				
				//echo $OccupancyDetail['date'].$OccupancyDetail['F&B'].$OccupancyDetail['typeName'];
					//array_key_exists($weatherDetail['Name'].'_hdd', $seriesCategory)
					$vt="_".$OccupancyDetail['typeName'];
					$seriesCategory['F&B'.$vt] = (!array_key_exists('F&B'.$vt, $seriesCategory)?'':$seriesCategory['F&B'.$vt]).$OccupancyDetail['F&B'].",";
					$seriesCategory['C&B'.$vt] = (!array_key_exists('C&B'.$vt, $seriesCategory)?'':$seriesCategory['C&B'.$vt]).$OccupancyDetail['C&B'].",";
					$seriesCategory['H&F'.$vt] = (!array_key_exists('H&F'.$vt, $seriesCategory)?'':$seriesCategory['H&F'.$vt]).$OccupancyDetail['H&F'].",";
					$seriesCategory['House Keeping'.$vt] = (!array_key_exists('House Keeping'.$vt, $seriesCategory)?'':$seriesCategory['House Keeping'.$vt]).$OccupancyDetail['House Keeping'].",";
					$seriesCategory['Plant'.$vt] = (!array_key_exists('Plant'.$vt, $seriesCategory)?'':$seriesCategory['Plant'.$vt]).$OccupancyDetail['Plant'].",";
					
					$seriesCategory['General'.$vt] = (!array_key_exists('General'.$vt, $seriesCategory)?'':$seriesCategory['General'.$vt]).$OccupancyDetail['General'].",";
					
					
				}
				
				//print_r($seriesCategory);
				
				$Occupancy['data_currentDay'] = $Occupancyitems;

			}
			
			{
		
		//headerFormat: '<b>{point.x}</b><br/><b>{series.options.stack}</b><br/>',
				 $OccupancyChartString = "{
						chart: {
							renderTo: 'SMDataBarChart_currentDate',
							type: 'column'
						},
						
						title: {
							text: 'Daily Comparison'
						},
						xAxis: {
							categories: [".implode(",",$chartCategory)."]
						},
						yAxis: {
							min: 0,
							title: {
								text: 'kWh'
							},
							stackLabels: {
								enabled: false,
								rotation: -90,
									 y: -25,
								style: {
									fontWeight: 'bold',
									color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
								}
							}
						},
						legend: {
							align: 'right',
							x: -30,
							verticalAlign: 'top',
							y: 25,
							floating: true,
							backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
							borderColor: '#CCC',
							borderWidth: 1,
							shadow: false
						},
						tooltip: {
							headerFormat: '<b>{series.options.stack}</b><br/>',
							pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
						},
						plotOptions: {
							column: {
								stacking: 'normal',
								dataLabels: {
									enabled: false,
									
									color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
									style: {
										textShadow: '0 0 3px black'
									}
								}
							}
						},
						series: [";
				$seriesstring = "";
				$cate =   array();
				$colindex=-1;
				foreach($seriesCategory as $x => $x_value) {
					$str = explode("_",$x);
					$idstr = "";
					if(!array_key_exists($str[0], $cate))
					{
						$idstr = "id: '".$str[0]."'";
						$cate[$str[0]] = 1;
					}
					else
					{
						$keys = array_keys($cate);
						$index = array_search($str[0],$keys);
						$idstr = "color: Highcharts.getOptions().colors[".$index."], linkedTo: '".$str[0]."'";
					}
						
					$seriesstring.="{name: '".$str[0]."' , $idstr ,data: [".rtrim($x_value, ',')."], stack: '".$str[1]."'},";
				}
				//echo "$seriesstring";
				$seriesstring = rtrim($seriesstring, ',');
				$OccupancyChartString.=$seriesstring;
					
				$OccupancyChartString.="
						]
					}";
					
					//echo $OccupancyChartString;
					//die();
				$Occupancy['BarChart'] = $OccupancyChartString;
			}
		}
		
		
		
		
		
			//print_r($seriesCategory);
			//die();
			
			$response['SMData']= $Occupancy;
	}
	
	
	

    echoResponse(200, $response);
});


$app->post('/PrepareAddRoleToObservationStatus', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	 

			$sql = "select k.*, ".$r->item->ID." rid from (select * from Portal_RolesToObservationStatus where 1=2) k right join (select 1 kk) h on (1=1)";
			$res = $db->getRecords($sql);
			$sql2 = "select * from Portal_ObservationStatus where id not in (select ObservationStatusID from Portal_RolesToObservationStatus where RoleID = ".$r->item->ID." )";
			$res2 = $db->getRecords($sql2);
			$res[0]['StatusDrp']  = $res2;

			$FormData['Data']  = $res;



			$response['AddRoleToObservationStatus']= $FormData;
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/GetAllContactFormMessages', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel

		
			$sql2 = "
			select m.*, u.Firstname, u.Lastname, c.Name HotelName,

				( 
					select count(*) from 
					Portal_ContactFormMessages 
					pm where 
					pm.ParentID IS not NULL and ifnull(pm.viewed,'') not like '%/".$session['uid']."/%' and pm.ParentID=m.ID 
					and pm.UserID != ".$session['uid']." 
				) 
				+
				(case when (m.Viewed is null OR ifnull(m.viewed,'') not like '%/".$session['uid']."/%') and m.UserID>1 then 1 else 0 end)

				newcount,
				(case when (m.Viewed is null OR ifnull(m.viewed,'') not like '%/".$session['uid']."/%') and m.UserID>1 then 0 else 1 end) viewedCnt
				from Portal_ContactFormMessages m 
                join Portal_Users u on (u.ID = m.UserID)
                left join creat072_vue.channel c on (m.HotelID=c.GroupId)
                where 
		                
		                (
			                m.UserID>1 and
			                ( 

				                exists 
					                (
						                select 1 
										from Portal_Users u 
										join Portal_UserTitleToRoles UTR on (u.Title = UTR.UserTitleID)
										where UTR.RoleID=m.RoleID 
						                and u.ID=".$session['uid']."
					                )
			                	OR m.UseriD = ".$session['uid']."
			                ) 
			                and m.ParentID IS NULL
		                )
		                OR 
		                (
		                	exists (select 1 from Portal_ContactFormMessages m1 where m1.ParentID = m.ID)
		                	and m.UserID=1
		                	and m.ParentID IS NULL
		                	
		                )
		                OR 
		                (
		                	m.UserID=1
		                	
		                	and m.ParentID IS NULL
		                	and m.RoleID is null
		                )
		                OR 
		                (
		                	m.UserID=1
		                	and  exists (select 1 
								from Portal_Users u 
								join Portal_UserTitleToRoles UTR on (u.Title = UTR.UserTitleID)
								where m.RoleID  like concat('%/',UTR.RoleID,'/%')    
				                and u.ID=".$session['uid']."
				                )
		                	
		                	and m.ParentID IS NULL
		                	and m.ToUserID is null
		                )
		                
		               
				

				";
				//echo $sql2."<br>";
		
			$res2 = $db->getRecords($sql2);
			$NewItemCount = 0;
			foreach($res2 as $item)
			{
				if($item['viewedCnt']=='0')
					$NewItemCount++;
			}
			//$FormData['Data']  = $res2;
			$response['status'] = "success";
			$response['message'] = 'Messages Loaded.';

			$response['NewCount']=$NewItemCount;
			$response['data']= $res2;
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/GetAllNewContactFormMessages', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel

		
			$sql2 = "
				select m.*,  u.Firstname, u.Lastname, c.Name HotelName 
				from Portal_ContactFormMessages m 
                join Portal_Users u on (u.ID = m.UserID)
                join creat072_vue.channel c on (m.HotelID=c.GroupId)
                where exists (select 1 
				from Portal_Users u 
				join Portal_UserTitleToRoles UTR on (u.Title = UTR.UserTitleID)
				where UTR.RoleID=m.RoleID 
                and u.ID=".$session['uid']."
                )
                and m.ParentID IS NULL and ifnull(m.Viewed,0) not like '%/".$session['uid']."/%' and m.UserID>1
                union All
                
                select m1.*, u.Firstname, u.Lastname , c.Name HotelName 
				from creat072_vue.Portal_ContactFormMessages m1 
				join creat072_vue.Portal_ContactFormMessages m
				on (m1.ParentID = m.ID)
				join creat072_vue.Portal_Users u on (u.ID = m1.UserID)
                join creat072_vue.channel c on (m.HotelID=c.GroupId)
                where
                 m1.ParentID IS not NULL and ifnull(m1.Viewed,'') not like '%/".$session['uid']."/%'
                 and m1.UserID != ".$session['uid']." and m1.UserID>1

                 union all

                 select m.*,  'Admin' Firstname, '' Lastname, c.Name HotelName 
				from creat072_vue.Portal_ContactFormMessages m 
                join creat072_vue.Portal_Users u on (u.ID = m.UserID)
                left join creat072_vue.channel c on (m.HotelID=c.GroupId)
                where 

                	 m.ParentID IS NULL and ifnull(m.Viewed,'') not like '%/".$session['uid']."/%' 
                     and m.UserID=1
                     and m.ToUserID like '%/".$session['uid']."/%' 

                union all
                 select m1.*,  u.Firstname, u.Lastname , c.Name HotelName 
				from Portal_ContactFormMessages m1 
				join Portal_ContactFormMessages m
				on (m1.ParentID = m.ID)
                join Portal_Users u on (u.ID = m1.UserID)
                left join creat072_vue.channel c on (m.HotelID=c.GroupId)
                where 

                	 m1.ParentID IS not NULL and ifnull(m1.Viewed,'') not like '%/".$session['uid']."/%' 
                     and m.UserID=1
                     

                union all
                  select m.*,  'Admin' Firstname, '' Lastname, c.Name HotelName 
				from Portal_ContactFormMessages m 
                join Portal_Users u on (u.ID = m.UserID)
                left join creat072_vue.channel c on (m.HotelID=c.GroupId)
                where exists (select 1 
				from Portal_Users u 
				join Portal_UserTitleToRoles UTR on (u.Title = UTR.UserTitleID)
				where m.RoleID  like concat('%/',UTR.RoleID,'/%')    
                and u.ID=".$session['uid']."
                )
                and 

                	 m.ParentID IS NULL and ifnull(m.Viewed,'') not like '%/".$session['uid']."/%' 
                     and m.UserID=1
                     and  m.ToUserID is null
				";
				//echo $sql2;

				

			$res2 = $db->getRecords($sql2);
			$NewItemCount = 0;
			foreach($res2 as $item)
			{
				//if($item['Viewed']=='0' || $item['Viewed']=='')
				if (strpos($item['Viewed'], "/".$session['uid']."/") === false)
					$NewItemCount++;
			}
			//$FormData['Data']  = $res2;
			$response['status'] = "success";
			$response['message'] = 'Messages Loaded.';

			$response['NewCount']=$NewItemCount;
			$response['data']= $res2;
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/GetContactFormMessage', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel


			$sql2 = "select m.*, (case when m.UserID=".$session['uid']." then 'You' else u.Firstname end) Firstname, u.Lastname 
			from 
			Portal_ContactFormMessages m 
			join 
			Portal_Users u on (m.UserID=u.ID) where m.ID = ".$r->dparams->MessageID;
			//echo $sql2;
			$res2 = $db->getRecords($sql2);
			

			$response['selectedMessage']= $res2;

			$sql2 = "select m.*, (case when m.UserID=".$session['uid']." then 'You' else u.Firstname end) Firstname, u.Lastname 
			from 
			Portal_ContactFormMessages m 
			join 
			Portal_Users u on (m.UserID=u.ID) where m.ID=".$r->dparams->MessageID." OR  m.ParentID=".$r->dparams->MessageID;
			$res2 = $db->getRecords($sql2);
			
			 

			$response['selectedMessageThread']= $res2;
			//$FormData['Data']  = $res2;
			$response['status'] = "success";
			$response['message'] = 'Message Loaded.';
			//$db->executeSQL("Update Portal_ContactFormMessages set Viewed=1 where UserID!=".$session['uid']." and (ID=".$r->dparams->MessageID." OR ParentID=".$r->dparams->MessageID.")");
			//echo "Update Portal_ContactFormMessages set Viewed=(case when Viewed='' then '/".$session['uid']."/' else '".$session['uid']."/' end) where Viewed not like '%/".$session['uid']."/%' and  UserID!=".$session['uid']." and (ID=".$r->dparams->MessageID." OR ParentID=".$r->dparams->MessageID.")";
			$db->executeSQL("Update Portal_ContactFormMessages set Viewed=(case when ifnull(Viewed,'') ='' then '/".$session['uid']."/' else concat(Viewed,'".$session['uid']."/') end) where ifnull(Viewed,'')  not like '%/".$session['uid']."/%' and  UserID!=".$session['uid']." and (ID=".$r->dparams->MessageID." OR ParentID=".$r->dparams->MessageID.")");
			
	}
	

	
	
	
	
    echoResponse(200, $response);
});







$app->post('/DoSaveRoleToObservationsStatus', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();

	if($r->dparams->InDropdown==1)
		$r->dparams->InDropdown = true;
	if($r->dparams->InView==1)
		$r->dparams->InView = true;
	if($r->dparams->CanEdit==1)
		$r->dparams->CanEdit = true;


	if($r->dparams->ID!= null || $r->dparams->ID>0)
	{
		
				$sql = "Update Portal_RolesToObservationStatus set ";
				$sql .= "RoleID = ".$r->dparams->rid.", ";
				$sql .= "ObservationStatusID = ".$r->dparams->ObservationStatusID.", ";
				$sql .= "InDropdown = ".($r->dparams->InDropdown?1:0).", ";
				$sql .= "InView = ".($r->dparams->InView?1:0).", ";
				$sql .= "CanEdit = ".($r->dparams->CanEdit?1:0)." ";
				$sql .= " where ID = '".$r->dparams->ID."' ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Status updated successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to update Title . Please try again";
						
					}   
			
	}
	else
	{


			
			
				$sql = "insert into Portal_RolesToObservationStatus  (RoleID, ObservationStatusID, InDropdown, InView, CanEdit) values (";
				$sql .= $r->dparams->rid.",".$r->dparams->ObservationStatusID.",".($r->dparams->InDropdown?1:0).",".($r->dparams->InView?1:0).",".($r->dparams->CanEdit?1:0).")";
				//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Status Added successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to add role details. Please try again";
					
				}   
			
	}
	
				
	
	
    echoResponse(200, $response);
	
});

$app->post('/DoDeleteRoleToObservationsStatus', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();


		
				$sql = "delete from Portal_RolesToObservationStatus  ";
				$sql .= " where ID = ".$r->dparams->ID." ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Status deleted successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to delete Status . Please try again";
						
					}   
			
	
	
    echoResponse(200, $response);
	
});


$app->post('/SubmitMessageThread', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel


			$orgmsg = $db->getRecords("select * from Portal_ContactFormMessages where ID=".$r->dparams->MessageID)[0];

			$sql = "Insert into 
			Portal_ContactFormMessages 
			(UserID,HotelID, RoleID, Message, CreatedDate, ParentID) 
			values 
			(".$session['uid'].",".($orgmsg['HotelID']==''?'NULL':$orgmsg['HotelID']).",".($orgmsg['RoleID']==''?'NULL':"'".$orgmsg['RoleID']."'").", '".$r->dparams->Message."', now(), ".$r->dparams->MessageID.")";
			$res2 = $db->executeSQL($sql);
			

			
			$response['status'] = "success";
			$response['message'] = 'Message added.';

			
	}
	

	
	
	
	
    echoResponse(200, $response);
});

$app->post('/SaveRoleContactMessagePermission', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel


			$sql = "Update Portal_Roles set AccessToContactFormMessages=".$r->dparams->AccessToContactFormMessages." where ID = ".$r->dparams->ID;
			$res2 = $db->executeSQL($sql);
			

			
			$response['status'] = "success";
			$response['message'] = 'Role Updated.';

			
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/GetToGroupForContactMessages', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel


			$sql2 = "select distinct R.* from Portal_UserToHotels UT 
				join Portal_Users U ON (U.ID = UT.UserID)
				join Portal_UserTitleToRoles UTR ON (UTR.UserTitleID=U.Title)
				JOIN Portal_Roles R ON (R.ID = UTR.RoleID)
			where R.AccessToContactFormMessages=1 and UT.HotelID=".$r->dparams->HotelID;
			$res2 = $db->getRecords($sql2);
			

			
			
			$response['data']= $res2;
			//$FormData['Data']  = $res2;
			$response['status'] = "success";
			$response['message'] = 'Message Loaded.';

			
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/PrepareAddMessageForm', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel


			$Roles = "select ID id, Name label from Portal_Roles";
			$Roles = $db->getRecords($Roles);
			$Users = "select ID id, concat(Firstname,' ',Lastname) label from Portal_Users where ID>1";
			$Users = $db->getRecords($Users);
			

			
			
			$response['data']['Roles'] = $Roles;
			$response['data']['Users'] = $Users;
			//$FormData['Data']  = $res2;
			$response['status'] = "success";
			$response['message'] = 'Message Loaded.';

			
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/AddNewMessageByAdmin', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();

	$users = 'NULL';
	//print_r($r->dparams->SelectedUsers);
	if(count($r->dparams->SelectedUsers)>0)
	{
		$users='';
		foreach ($r->dparams->SelectedUsers as $value) {
			$users = $users."/".$value->id;
		}
		$users = $users."/";
		$users = "'".$users."'";
	}

	$roles = 'NULL';
	if(count($r->dparams->SelectedRoles)>0)
	{
		$roles = '';
		foreach ($r->dparams->SelectedRoles as $value) {
			$roles = $roles."/".$value->id;
		}
		$roles = $roles."/";
		$roles = "'".$roles."'";
	}
	//echo $users."<br>";
	//echo $roles;
	//die();
				
				$sql = "insert into Portal_ContactFormMessages  (UserID,RoleID,ToUserID, Subject,Message,CreatedDate,Viewed) values (";
                                $sql .= $session['uid'].", ";
                                $sql .= $roles.", ";
                $sql .= $users.", ";
				$sql .= "'".$r->dparams->Subject."', ";
				$sql .= "'".$r->dparams->Message."', ";
				$sql .= "now(), ";
				$sql .= "NULL);";
			//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Message saved and sent";
					
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to send and save Message ";
					
				}   

		
		
                
	
	
	
    echoResponse(200, $response);
	
});

$app->post('/DeleteContactFormMessage', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();


		


				$sql = "delete from Portal_ContactFormMessages  ";
				$sql .= " where ParentID = ".$r->dparams->ID." or ID = ".$r->dparams->ID;
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Message deleted successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to delete Message . Please try again";
						
					}   
			
	
	
    echoResponse(200, $response);
	
});


$app->post('/GetReportsToDownload', function() use ($app) {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());

    $response['status'] = "success";
	$response['message'] = 'Files for download loaded successfully.';
	$fileList = array();
	$settings = $db->GetSettingsMaster();
	//$path = REPORT_FOLDER_PATH;
	//echo $settings;
	$path = $settings->Reports_RootFolder;
	//print_r($settings);

	//$directories = glob($path . '/*' , GLOB_ONLYDIR);
	$directories[]="";
	$Entries = $db->recursive_list($path);
	//print_r($Entries);
	$items = array();
	foreach ($Entries as $key => $entry) {
		//print_r($entry);

		if($entry['dir']==0)
		{
			if((strpos($entry['Files'], $r->dparams->Hotel->Name) !== false))
			{
				$item['FileName']=$entry['Files'];
				$item['FolderName']="";
				$items[] = $item;
			}
		}
		else
		{
			$directories[]=$key;
			foreach ($entry['Files'] as $key1 => $file) {
				
				if((strpos($file['Files'], $r->dparams->Hotel->Name) !== false))
				{
				
						$item['FileName']=$file['Files'];
						$item['FolderName']=$key;
						$items[] = $item;
				}
			}
		}
	}
	//print_r($items);
	$response['ReportFiles'] = $items;
	$response['directories'] = $directories;	
	
			$EmailTemplateSQl = "select * from Portal_ReportFile_NotificationTemplate where TemplateName='ReportReady'
			 and (HotelID= ".$r->dparams->Hotel->GroupId." OR HotelID is NULL) order by ifnull(HotelID,1000)";
			$Templates = $db->getOneRecord($EmailTemplateSQl);
			$response['ReportReadyEmailtemplate'] = $Templates;
	
	$userSql = "select U.ID, U.Email, concat(U.Firstname,' ',U.Lastname) Name from Portal_Users U 
		JOIN Portal_UserToHotels UH ON (U.ID=UH.UserID) 
		JOIN Portal_UserTitleToRoles UTR ON (U.Title = UTR.UserTitleID)
		JOIN Portal_RolesToPermissions RTP ON (RTP.RoleID = UTR.RoleID AND RTP.PermissionID=115 AND RTP.Active=1)
			 and UH.HotelID= ".$r->dparams->Hotel->GroupId." 
			 and U.Active=1
			 and U.ID=24 AND UTR.RoleID NOT IN (12)
			 ";
			 //
			$ToUsers = $db->getRecords($userSql);
			$response['ReportSendToUsersList'] = $ToUsers;

    echoResponse(200, $response);
});


$app->get('/DownloadReport', function() use ($app) {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());
	//$path = REPORT_FOLDER_PATH;
	$settings = $db->GetSettingsMaster();
	$path = $settings->Reports_RootFolder;
	//$file = $r->dparams->FolderName."/".$r->dparams->FileName;
	$fname = $_GET['FileName'];
	$FileName = $_GET['FileName'];
	$FolderName = $_GET['FolderName'];
	if($FolderName!="")
		$FolderName = "$FolderName/";
	$file = "$FolderName$FileName";
	$file = $path."/".$file;
  
	// grab the requested file's name
	$file_name = $file;

	// make sure it's a file before doing anything!

	$db->writeLog($session['uid'],"Report Downloaded :  ".$FolderName.$FileName,$_SESSION['HotelID'],'Report Download');

	$tmp = explode(".",$fname);
	switch ($tmp[count($tmp)-1]) {
	  case "pdf": $ctype="application/pdf"; break;
	  case "exe": $ctype="application/octet-stream"; break;
	  case "zip": $ctype="application/zip"; break;
	  //case "docx":
	  //case "doc": $ctype="application/msword"; break;
	  case "docx":
	  case "doc": $ctype="application/octet-stream"; break;
	  //case "csv":
	  //case "xls":
	  //case "xlsx": $ctype="application/vnd.ms-excel"; break;
	  case "csv":
	  case "xls":
	  case "xlsx": $ctype="application/octet-stream"; break;
	  //case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
	  case "ppt": $ctype="application/octet-stream"; break;
	  case "gif": $ctype="image/gif"; break;
	  case "png": $ctype="image/png"; break;
	  case "jpeg":
	  case "jpg": $ctype="image/jpg"; break;
	  case "tif":
	  case "tiff": $ctype="image/tiff"; break;
	  case "psd": $ctype="image/psd"; break;
	  case "bmp": $ctype="image/bmp"; break;
	  case "ico": $ctype="image/vnd.microsoft.icon"; break;
	  default: $ctype="application/force-download";
	}

	//echo $ctype;
	header('Content-Description: File Transfer');
	header("Pragma: public"); // required
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false); // required for certain browsers
	header("Content-Type: $ctype");
	header("Content-Disposition: attachment; filename=\"".$fname."\";" );
	//header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($file_name));
	ob_clean();
	flush();
	readfile($file_name);
	exit;
//echoResponse(200, $response);
});


$app->post('/ReportsFileUpload', function() use ($app)      
{

    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	$settings = $db->GetSettingsMaster();


	if(!empty($_FILES['uFile'])){
		$ext = pathinfo($_FILES['uFile']['name'],PATHINFO_EXTENSION);
		//$HotelName = $_POST['HotelName'];
		$Foldername = $_POST['ReportType'];
		if($Foldername!="")
			$Foldername = "$Foldername/";
                //$image = time().'.'.$ext;
				$fileName = $_FILES['uFile']['name'];
                move_uploaded_file($_FILES["uFile"]["tmp_name"], $settings->Reports_RootFolder."/".$Foldername.$fileName);
                $db->writeLog($session['uid'],"Report Uploaded :  ".$Foldername.$fileName,$_SESSION['HotelID'],'Report Uploaded');
		//echo "Image uploaded successfully as ".$image;
		$response["status"] = "success";
		$response["message"] = "File uploaded successfully";
	}else{
		//echo "Image Is Empty";
		$response["status"] = "success";
		$response["message"] = "File Is Empty";
	}
	
	echoResponse(200, $response);
});


$app->post('/DeleteReportFile', function() use ($app)      
{

    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());
	if($r->dparams->FolderName!="")
			$r->dparams->FolderName = $r->dparams->FolderName."/";

	$settings = $db->GetSettingsMaster();

	$fileName = $settings->Reports_RootFolder."/".$r->dparams->FolderName.$r->dparams->FileName;
	//echo $fileName;
	if(file_exists($fileName)){
		
		if(unlink($fileName))
		{
			$db->writeLog($session['uid'],"Report Deleted :  ".$r->dparams->FolderName.$r->dparams->FileName,$_SESSION['HotelID'],'Report Deleted');
			$response["status"] = "success";
			$response["message"] = "File Deleted successfully";
		}
		else{
		//echo "Image Is Empty";
			$response["status"] = "success";
			$response["message"] = "An error during file delete";
		}
	}else{
		//echo "Image Is Empty";
		$response["status"] = "success";
		$response["message"] = "File does not exists";
	}
	
	echoResponse(200, $response);
});


$app->post('/SaveReportReadyTemplate', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();

	if($r->dparams->ID>1)
	{
		
				$sql = "Update Portal_ReportFile_NotificationTemplate set ";
				$sql .= "HotelID = ".$r->dparams->HotelID.", ";
				$sql .= "TemplateName = '".addslashes($r->dparams->TemplateName)."', ";
				$sql .= "HtmlContent = '".addslashes($r->dparams->HtmlContent)."' ";
				$sql .= " where ID = '".$r->dparams->ID."' ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Template updated successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to update Template . Please try again";
						
					}   
			
	}
	else
	{


			
			
				$sql = "insert into Portal_ReportFile_NotificationTemplate  (HotelID, TemplateName, HtmlContent) values (";
				$sql .= $r->dparams->HotelID.",'".addslashes($r->dparams->TemplateName)."','".addslashes($r->dparams->HtmlContent)."')";
				//echo $sql;
				$result = $db->executeInsert($sql);
				if ($result != NULL) {
					$response["status"] = "success";
					$response["message"] = "Template updated successfully";
					$response["ID"] = $result;
					$r->dparams->ID = $result;
					
				} else {
					$response["status"] = "error";
					$response["message"] = "Failed to update Template. Please try again";
					
				}   
			
	}
	
				
	
	
    echoResponse(200, $response);
	
});



$app->post('/SendReportReadyNotificationEmail', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;

	{ // Load channel
	 
		 

		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail = $db->AttachMailerSettings($mail)     ;
		                            // TCP port to connect to

		//$userSql = "select U.ID, U.Email, concat(U.Firstname,' ',U.Lastname) Name from Portal_Users U 
		//JOIN Portal_UserToHotels UH ON (U.ID=UH.UserID) 
		//JOIN Portal_UserTitleToRoles UTR ON (U.Title = UTR.UserTitleID)
		//JOIN Portal_RolesToPermissions RTP ON (RTP.RoleID = UTR.RoleID AND RTP.PermissionID=115 AND RTP.Active=1)
		//	 and UH.HotelID= ".$r->dparams->Email->HotelID." and U.ID=24 AND UTR.RoleID NOT IN (12)";
		//	$ToUsers = $db->getRecords($userSql);
		$ToUsers = $r->dparams->ToUsers;
//echo $userSql;
		//print_r($ToUsers);
		//die();
		if($ToUsers!=null)
		{
			//$mail->addAddress
			//foreach ($ToUsers as $user) {
			//	$mail->AddBCC($user['Email'], $user['Name']); 
			//}
			

			foreach ($ToUsers as $user) {
				if($user->Checked==1)
				$mail->AddBCC($user->Email, $user->Name); 
			}

			//print_r($ToUsers);
			//die();

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = $r->dparams->Email->Subject;
			//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->Body    = $r->dparams->Email->HtmlContent;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				//echo 'Message could not be sent.';
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
				$LogRes['status'] = "error";
				$LogRes['message'] = $mail->ErrorInfo;
			} else {
				//echo 'Message has been sent';
					$LogRes['status'] = "success";
					$LogRes['message'] = 'Reports : Email Sent';
			
			}
		}
		else
		{
				$LogRes['status'] = "error";
				$LogRes['message'] = "Reports : No users found to email";
		}

		//$mail->addAddress('tigerobjects@gmail.com', 'tigerobjects');     // Add a recipient

		
	 
			
			$response['data']= $LogRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});


$app->post('/MailThisReportFileToMe', function() use ($app)    
{
	$r = json_decode($app->request->getBody());
    $db = new DbHandler();
	$session = $db->getSession();
	$response = null;
	$settings = $db->GetSettingsMaster();
	//print_r($r->dparams);
	//die();

	{ // Load channel
	 
		 

		$mail = new PHPMailer;
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail = $db->AttachMailerSettings($mail)     ;
		                            // TCP port to connect to

		$userSql = "select U.ID, U.Email, concat(U.Firstname,' ',U.Lastname) Name from Portal_Users U 
		
			 where  U.ID=".$session['uid'];
			$ToUsers = $db->getRecords($userSql);
			
//echo $userSql;
		//print_r($ToUsers);
		//die();
		if($ToUsers!=null)
		{
			foreach ($ToUsers as $user) {
				$mail->addAddress($user['Email'], $user['Name']); 
			}

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = "Here is your file(s)";
			//$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
			$mail->Body    = "Attached is the file(s) you requested";

			foreach ($r->dparams as $item) {
				if($item->FolderName!="")
				$item->FolderName = $item->FolderName."/";

				$fileName = $settings->Reports_RootFolder."/".$item->FolderName.$item->FileName;
				# code...
				$mail->addAttachment($fileName, $item->FileName); 
			}
			

			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->send()) {
				//echo 'Message could not be sent.';
				//echo 'Mailer Error: ' . $mail->ErrorInfo;
				$LogRes['status'] = "error";
				$LogRes['message'] = $mail->ErrorInfo;
			} else {
				//echo 'Message has been sent';
					$LogRes['status'] = "success";
					$LogRes['message'] = 'Reports : File is Emailed to your profile Email address.';
			
			}
		}
		else
		{
				$LogRes['status'] = "error";
				$LogRes['message'] = "No users found to email";
		}

		//$mail->addAddress('tigerobjects@gmail.com', 'tigerobjects');     // Add a recipient

		
	 
			
			$response['data']= $LogRes;
	}
	

	
	
	
	
    echoResponse(200, $response);
});



$app->get('/GetAllSettings', function() {	
    $db = new DbHandler();
	$session = $db->getSession();
	
	//echo "test";
    $response['status'] = "success";
	$response['message'] = 'Logged in successfully.';
			$settings = $db->GetSettingsMaster();
			$response['Settings'] = $settings;
		
		
	
    echoResponse(200, $response);
});

$app->post('/DoSaveSettings', function() use ($app) 
{
 
    $r = json_decode($app->request->getBody());
    $response = array();
    $db = new DbHandler();
	$session = $db->getSession();

	
	
				$sql = "Update Portal_SettingsMaster set ";
				$sql .= "Emailer_Host = '".$r->dparams->Emailer_Host."', ";
				$sql .= "Emailer_From_Name = '".$r->dparams->Emailer_From_Name."', ";
				$sql .= "Emailer_UserName = '".$r->dparams->Emailer_UserName."', ";
				$sql .= "Emailer_Password = '".$r->dparams->Emailer_Password."', ";
				$sql .= "Emailer_Port = '".$r->dparams->Emailer_Port."', ";
				$sql .= "Reports_RootFolder = '".$r->dparams->Reports_RootFolder."' ";
				$sql .= " where ID = '".$r->dparams->ID."' ";
				//echo $sql;
					$result = $db->executeSQL($sql);
					if ($result != NULL) {
						$response["status"] = "success";
						$response["message"] = "Settings updated successfully";
						$response["ID"] = $r->dparams->ID;
						
					} else {
						$response["status"] = "error";
						$response["message"] = "Failed to update Title . Please try again";
						
					}   

    echoResponse(200, $response);
	
});


$app->post('/GetHeaderMessages', function() use ($app) {
	
    $db = new DbHandler();
	$session = $db->getSession();
	$r = json_decode($app->request->getBody());

   
	
			$msgSQL = "select * from Portal_HeaderMessages where HotelID= ".$r->dparams->GroupId." OR HotelID IS NULL   
 				and Active=1
			";
			$messages = $db->getRecords($msgSQL);
			$response['HeaderMessages'] = $messages;
	
    echoResponse(200, $response);
});


?>