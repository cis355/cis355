<?php


class Database 
{
	private static $dbName = 'arhender' ; #database name
	private static $dbHost = 'localhost' ; #host
	private static $dbUsername = 'arhender'; #mysql connection username
	private static $dbUserPassword = '530612'; #mysql connection password

	private static $cont  = null; #connection string
	
	#instantiation not allowed
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
          self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword); 
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
		self::$cont = null; #set the connection to null
	}
	
}
?>