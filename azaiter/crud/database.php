<?php
class Database 
{
    # commented out code below...
    /*
	private static $dbName = 'gpcorser' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'gpcorser';
	private static $dbUserPassword = 'remember';
	*/
	# added code below ...
	private static $dbName = 'azaiter' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'azaiter';
	private static $dbUserPassword = '604845';
	# added code above ...
	
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