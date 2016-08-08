<?php
/* *******************************************************************
 filename     : database.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cis355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  :  This file contains the logic of a class for connecting to the database via mysqli
 
Process:
N/A

Current File:
http://csis.svsu.edu/~arhender/cis355/arhender/Program2/database.php

Links to class, database file, and UML Class diagram:
1.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworks.php
2.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/database.php
3.http://csis.svsu.edu/~arhender/cis355/arhender/Program2/artworkUMLdiagram.JPG
*********************************************************************  */

show_source(__FILE__);
class database
{
	
	private static $dbName = 'arhender'; #database name
	private static $dbHost = 'localhost'; #host
	private static $dbUsername = 'arhender'; #mysql connection username
	private static $dbUserPassword = '530612'; #mysql connection password
	private static $mysqli  = null; #connection string
	
	
	#instantiation not allowed
	public function __construct() 
	{
		exit('Init function is not allowed');
	}	
	
	 public static function connect()
	 {
	 
		 
       self::$mysqli = mysqli_connect(self::$dbHost,self::$dbUsername,self::$dbUserPassword,self::$dbName);

	   // Check connection
		if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		return self::$mysqli;#return the mysqli object after connecting
	
     }
	
	public static function disconnect()
	{
		mysqli_close(self::$cont); #set the connection to null
	}
	
	public static function getmysqli()
	{
		return self::$mysqli; #set the connection to null
	}
	
}
	
?>