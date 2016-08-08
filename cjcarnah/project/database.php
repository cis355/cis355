<?php

/* *******************************************************************
* filename : database.php
* author : Charles Carnahan
* username : cjcarnah
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* This file is used to connect to a database
*
* input : user input
*
* precondition : database with tables 'users', 'lifts', and 'userLifts' exists
* *******************************************************************
*/

error_reporting(E_ALL);

class Database 
{
	private static $dbName = 'cjcarnah' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'cjcarnah';
	private static $dbUserPassword = '546310';

    PUBLIC static $con  = null;

	public function __construct() {
		exit('Init function is not allowed');
	}
	
	public static function connect()
	{
	   // One connection through whole application
       if ( null == self::$con )
       {      
            self::$con = new mysqli(self::$dbHost, self::$dbUsername, self::$dbUserPassword, self::$dbName);  

            // Check connection
            if ($con->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 
        }      

        return self::$con;
    }

	public static function disconnect()
	{
		self::$con = null;
	}
}
?>