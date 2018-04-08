<?php

class DbHandler {

    private $conn;
	

    function __construct() {
        require_once 'dbConnect.php';
        // opening db connection
        $db = new dbConnect();
        $this->conn = $db->connect();
    }
	
	
	public function connecttowor9() {
		$db = new dbConnect();
        $this->conn = $db->wor9connect();
    }
    /**
     * Fetching single record
     */
    public function getOneRecord($query) {
        $r = $this->conn->query($query.' LIMIT 1') or die($this->conn->error.__LINE__);
        return $result = $r->fetch_assoc();    
    }


    public function GetSettingsMaster() {
        $r = $this->conn->query("select * from Portal_SettingsMaster".' LIMIT 1') or die($this->conn->error.__LINE__);
        $record= $result = $r->fetch_assoc();   
        $object = new StdClass;
        $object->ID = $record['ID'];
        $object->Emailer_Host = $record['Emailer_Host'];
        $object->Emailer_Smtp_Auth = $record['Emailer_Smtp_Auth'];
        $object->Emailer_From_Name = $record['Emailer_From_Name'];
        $object->Emailer_UserName = $record['Emailer_UserName'];
        $object->Emailer_Password = $record['Emailer_Password'];
        $object->Emailer_Smtp_Secure = $record['Emailer_Smtp_Secure'];
        $object->Emailer_Port = $record['Emailer_Port'];
        $object->Reports_RootFolder = $record['Reports_RootFolder'];
        return ($object);
       

    }

    public function AttachMailerSettings($mail) {
        //$r = $this->conn->query("select * from Portal_SettingsMaster".' LIMIT 1') or die($this->conn->error.__LINE__);
        //$record= $result = $r->fetch_assoc();   
        //$object = new StdClass;

        $settings = $this->GetSettingsMaster();
        /*$mail->Host = $record['Emailer_Host'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $record['Emailer_UserName'];                 // SMTP username
        $mail->Password = $record['Emailer_Password'];                           // SMTP password
        $mail->SMTPSecure = $record['Emailer_Smtp_Secure'];                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $record['Emailer_Port'];  
        $mail->setFrom($record['Emailer_UserName'], $record['Emailer_From_Name']);*/

        $mail->Host = $settings->Emailer_Host;  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $settings->Emailer_UserName;                 // SMTP username
        $mail->Password = $settings->Emailer_Password;                           // SMTP password
        $mail->SMTPSecure = $settings->Emailer_Smtp_Secure;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $settings->Emailer_Port;  
        $mail->setFrom($settings->Emailer_UserName, $settings->Emailer_From_Name);
        //return json_encode($object);
        return $mail;

    }
	
	public function writeLog($UserID=NULL,$Description=NULL,$HotelID=NULL,$NameOfWidget=NULL) {

        if($Description != null)
            $Description = "'".$Description."'";
        else 
            $Description = "NULL";

        if($NameOfWidget != null)
            $NameOfWidget = "'".$NameOfWidget."'";
        else
            $NameOfWidget = "NULL";

        if($HotelID != null)
            $HotelID = "'".$HotelID."'";
        else
            $HotelID = "NULL";

		$query = "Insert into Portal_Logs (UserID, CreatedDate,Description,HotelID,WidgetName) 
        values ($UserID,now(),$Description,$HotelID,$NameOfWidget)";
		//echo $query;
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);
        if ($r) {
            
            return 1;
            } else {
            return NULL;
        }    
    }
	
	public function getRecords($query) {
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);
		//$r = $this->conn->query($query) or die("erro");
		$data = array();
             if($r->num_rows > 0){
                 
                 while($row = $r->fetch_assoc()){
                     $data[] = $row;
                 }
			 }
		return $data;
        //return $result = $r->fetch_assoc();    
    }
    /**
     * Creating new record
     */
    public function insertIntoTable($obj, $column_names, $table_name) {
        
        $c = (array) $obj;
        $keys = array_keys($c);
        $columns = '';
        $values = '';
        foreach($column_names as $desired_key){ // Check the obj received. If blank insert blank into the array.
           if(!in_array($desired_key, $keys)) {
                $$desired_key = '';
            }else{
                $$desired_key = $c[$desired_key];
            }
            $columns = $columns.$desired_key.',';
            $values = $values."'".$$desired_key."',";
        }
        $query = "INSERT INTO ".$table_name."(".trim($columns,',').") VALUES(".trim($values,',').")";
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            $new_row_id = $this->conn->insert_id;
            return $new_row_id;
            } else {
            return NULL;
        }
    }
	
	public function executeSQL($query) {
        
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            
            return 1;
            } else {
            return NULL;
        }
    }
	
	public function executeInsert($query) {
        
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            
            $new_row_id = $this->conn->insert_id;
            return $new_row_id;
            } else {
            return NULL;
        }
    }
	
public function getSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['uid']))
    {
        $sess["uid"] = $_SESSION['uid'];
        $sess["name"] = $_SESSION['name'];
        $sess["email"] = $_SESSION['email'];
		$sess["isadmin"] = $_SESSION['isadmin'];
		$sess["userWidgets"] = $_SESSION['userWidgets'];
		//$sess["userHotels"] = $_SESSION['userHotels'];
    }
    else
    {
        $sess["uid"] = '';
        $sess["name"] = 'Guest';
        $sess["email"] = '';
		$sess["isadmin"] = '';
		$sess["userWidgets"] = null;

		//$sess["userHotels"] = null;
    }
    return $sess;
}
public function destroySession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['uid']))
    {
        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
		unset($_SESSION['isadmin']);
		unset($_SESSION['userWidgets']);
		//unset($_SESSION['userHotels']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}

public function buildtree($src_arr, $parent_id = 0, $tree = array())
         {
             foreach($src_arr as $idx => $row)
             {
                 if($row['ParentId'] == $parent_id)
                 {
                     foreach($row as $k => $v)
                         $tree[$row['GroupId']][$k] = $v;
                     unset($src_arr[$idx]);
                     $tree[$row['GroupId']]['Channels'] = $this->buildtree($src_arr, $row['GroupId']);
                 }
             }
             sort($tree);
             return $tree;
         }


         public function recursive_list($path) {
            $obj_rdi = new RecursiveDirectoryIterator($path);
            $files = array();
            foreach ($obj_rdi as $file) {
            if ('.' != $file->getFilename() && '..' != $file->getFilename() && '.DS_Store' != $file->getFilename()) {
            if ($file->isDir()) {
            $files[$file->getFilename()] = array("dir"=>1,"Files"=>$this->recursive_list($file->getPathname()));
            } else {
            $files[] = array("dir"=>0,"Files"=>$file->getFilename());
            }
            }
            }
            return $files;
        }
 
}



?>
