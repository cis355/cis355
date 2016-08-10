<!--
/* *******************************************************************
* filename : database.php
* author : Gage Beckett
* username : sgbecket
* course : CIS355
* section : 11-MW
* semester : Summer 2016
*
* description : connects to the database. Not sure if I used it as I wrote most of this in 
* a haze and don't want to remove the file for fear that it will break the program.
*
* input : none
* output : database connection variable
*
* precondition : valid database
* postcondition: none
* *******************************************************************-->
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
	private static $dbName = 'sgbecket' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'sgbecket';
	private static $dbUserPassword = '42BeckettSG';
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