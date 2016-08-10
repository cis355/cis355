<?php
/* *******************************************************************
 filename     : database.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the class used to connect to the database
				to allow for database processing.
*********************************************************************  */

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

/*************************************************************		
FUNCTION: connect
Parameters   :  n/a
				
purpose       : The purpose of this function is to connect to the
				defined database.
				
output        : n/a
precondition  : correct database credentials, existing tables.
postcondition : need to disconnect after processing is complete. 
****************************************************************/	
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

/*************************************************************		
FUNCTION: disconnect
Parameters   :  n/a
				
purpose       : The purpose of this function is to disconnect from the
				defined database.
				
output        : n/a
precondition  : existing connection is in place to the database.
postcondition : the connection is terminated from the database. 
****************************************************************/		
	public static function disconnect()
	{
		self::$cont = null; #set the connection to null
	}
}
?>