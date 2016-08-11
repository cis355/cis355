<?php
/* ***************************************************************************************************************
 filename     : elitedatabase.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file sets up the database to be used throughout the project
				
PURPOSE 	  : Database setup
INPUT		  : dbName, dbHost, dbusername, dbUserPassword
PRE     	  : None
OUTPUT		  : database is generated and found
POST		  : the database is found on the system and is ready for use.
*****************************************************************************************************************/
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
	private static $dbName = 'cbetz' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'cbetz';
	private static $dbUserPassword = '547295';
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