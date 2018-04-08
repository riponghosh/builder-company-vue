<?php

class dbConnect {

    private $conn;

    function __construct() {        
    }

    /**
     * Establishing database connection
     * @return database connection handler
     */
    function connect() {
        include_once '../config.php';

        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        //mysqli_set_charset('utf8',$this->conn);
        mysqli_set_charset($this->conn,"utf8");
        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $this->conn;
    }
	
	function wor9connect() {
        include_once '../config.php';
		
        // Connecting to mysql database
        $this->conn = new mysqli(WOR9DB_HOST, WOR9DB_USERNAME, WOR9DB_PASSWORD, WOR9DB_NAME);

        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // returing connection resource
        return $this->conn;
    }

}

?>
