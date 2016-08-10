<?php
/* *******************************************************************
* filename : database.php
* author : Jenny Bober
* username : jmbober
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : File that connects to database
*
* Structure: Database class
              -Declares variables
              -constructor function
              -connect function
              -disconnect function

* precondition : N/A
* postcondition: If the database exists and username and password are correct,
                  connect to the database when connect() function is called and 
                  disconnect when disconnect() is called
*
* Code adapted from George Corser
* *******************************************************************/
class Database 
{
	private static $dbName = 'jmbober' ; 
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'jmbober';
	private static $dbUserPassword = '549391';

	private static $cont  = null;
	
	public function __construct() {
		exit('Init function is not allowed');
	}
	
	public static function connect(){
    // One connection through whole application
    if ( null == self::$cont ){      
      try{
        self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".
        self::$dbName, self::$dbUsername, self::$dbUserPassword);  
      }
      catch(PDOException $e){
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