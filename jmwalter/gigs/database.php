<?php
/* *******************************************************************
* filename : database.php
* author : Joshua Walters
* username : jmwalter
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : this page is included in all other pages that use database functions
*
* purpose: this page sets up the connection information needed to link to our database and get 
* table data. it handles the connect and disconnect functions and errochecking on connections
*
* input : no input
*
* processing : 
* 1. sets up member data
* 2. sets up constructor
* 3. sets up the connection method to connect to said database
* 4. sets up the disconnect method to close the connection to the db
* 
* output : no output
*
* precondition : no precondition for class to run.
* *******************************************************************
*/
class Database 
{
	private static $dbName = 'joshthetechguyprojectsdb' ; 
	private static $dbHost = 'mysql.joshthetechguy.tech' ;
	private static $dbUsername = 
	private static $dbUserPassword =
	
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
		self::$cont = null;
	}
}
?>