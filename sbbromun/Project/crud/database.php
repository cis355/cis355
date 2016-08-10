<?php
/* *******************************************************************
* filename : database.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file provides necessary info to connect to the
*	database. used by all other files to connect
* input : None
*
* precondition : None
* postcondition: None
* *******************************************************************
*/
class Database 
{
	//Private Data members
	private static $dbName = 'sbbromun' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'sbbromun';
	private static $dbUserPassword = '592880';
	
	private static $cont  = null;
	
	public function __construct() {
		exit('Init function is not allowed');
	}
	
	public static function connect()
	{
	//Function connects to the database.
	/* *******************************************************************
	* input : N/A
	* processing : Uses private data to connect to database with PDO
	* output : none
	*
	* precondition : not connected.
	* postcondition: Connected to the database.
	* *******************************************************************
	*/	
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
	//Function disconnects from the database.
	/* *******************************************************************
	* input : N/A
	* processing : Disconnectes from the server
	* output : none
	*
	* precondition : connected to database
	* postcondition: disconnected from the database.
	* *******************************************************************
	*/	
		self::$cont = null;
	}
}
?>