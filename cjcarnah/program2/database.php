<?php

error_reporting(E_ALL);

//$con = null;

class Database 
{
	# added code below ...
	private static $dbName = 'cjcarnah' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'cjcarnah';
	private static $dbUserPassword = '546310';
	# added code above ...
	
	private static $cont  = null;
    PUBLIC static $con  = null;
	
	public function __construct() {
		exit('Init function is not allowed');
	}
	
	public static function connect()
	{
	   // One connection through whole application
       if ( null == self::$con )
       {      
          //self::$con =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);  
            self::$con = new mysqli(self::$dbHost, self::$dbUsername, self::$dbUserPassword, self::$dbName);  
            
            //echo 'in';
            
            //var_dump(self::$con);
            //echo self::$con->server_version;
         
            
           //echo self::$dbHost . self::$dbUsername . self::$dbUserPassword . self::$dbName;
           
            // Check connection
            if ($con->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
            //echo "Connected successfully";
        } 
           
           //$query = self::$con->query('Select * from customers') or die("Can't fetch data");
                      
        return self::$con;
    }
	
	public static function disconnect()
	{
		self::$con = null;
	}
}
?>