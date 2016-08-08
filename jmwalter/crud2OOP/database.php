<?php
class Database 
{
    # commented out code below...
    /*
	private static $dbName = 'jmwalter' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'jmwalter';
	private static $dbUserPassword = '580055';
	*/
	# added code below ...
	private static $dbName = 'jmwalter' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'jmwalter';
	private static $dbUserPassword = '580055';
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