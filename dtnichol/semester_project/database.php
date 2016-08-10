 <!--/* *******************************************************************
* filename : database.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : connects to the database			                 
*               
*
* input : need database login information
* processing : The program steps are as follows.
* 		1. login information must be correct in php code
* 		
* 		
* 		
* output : none
*
* precondition : none
* postcondition: database connection successfull
* 				 
* *******************************************************************
*/-->

<?php
//database connection
class Database 
{
    # commented out code below...
    /*
	private static $dbName = 'dtnichol' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'dtnichol';
	private static $dbUserPassword = '99DT44Nichols';
	*/
	# added code below ...
	/*private static $dbName = 'gpcorser' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'gpcorser';
	private static $dbUserPassword = 'remember';*/
	# added code above ...
	
	//credentials
	private static $dbName = 'dtnichol' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'dtnichol';
	private static $dbUserPassword = '99DT44Nichols';
	
	private static $cont  = null;
	
	public function __construct() {
		exit('Init function is not allowed');
	}
	
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
	
	public static function disconnect()
	{
		self::$cont = null;
	}
}
?>