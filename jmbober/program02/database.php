<?php

/* *******************************************************************
* filename : database.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This file allows my program to access my database
*
*
* Code from professor Corser
*
* *******************************************************************/ 
class Database 
{

	# added code below ...
	private static $dbName = 'jmbober' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'jmbober';
	private static $dbUserPassword = '549391';
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

show_source(__FILE__); 
?>