<?php
/* *******************************************************************  
* filename     : databaseProject.php  
* author       : Erik Federspiel & Star Tutorial
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : cs355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : php file connects to my mySQL database to edit it 
				 the tables within with the sql queries.
 *  
 * processing   : The program steps are as follows.   
 *          1. get database information
 *          2. connect to databse with info
 *          3. have disconnect frunction
 
 * output       : table with correct information
 *  
 * precondition : css documents and php filescss documents and php files in same directory
 * postcondition: actions based on button clicks
 
//Pre - none
//Post - exit
public function __construct()
	
//Pre - already be connected
//Post - disconnect
public static function disconnect()

//Pre - none
//Post - exit
public function __construct()
 * *******************************************************************   */ 
 ?>

<?php
class Database 
{
    # commented out code below...
    /*
	private static $dbName = 'ecfeders' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'ecfeders';
	private static $dbUserPassword = 'Nurseal5';
	*/
	# added code below ...
	private static $dbName = 'ecfeders' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'ecfeders';
	private static $dbUserPassword = 'Nurseal5';
	# added code above ...
	
	private static $cont  = null;
	
	//Constructor
	//Pre - none
	//Post - exit
	public function __construct() {
		exit('Init function is not allowed');
	}
	
	//Connect to databse
	//Pre - have variables set above
	//Post Connect to databse
	public static function connect()
	{
	   // One connection through whole application
       if ( null == self::$cont )
       {      
        try 
        {
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".
		  self::$dbName, self::$dbUsername, self::$dbUserPassword);  
        }
        catch(PDOException $e) 
        {
          die($e->getMessage());  
        }
       } 
       return self::$cont;
	}
	
	//Disconnect
	//Pre - already be connected
	//Post - disconnect
	public static function disconnect()
	{
		self::$cont = null;
	}
}
?>