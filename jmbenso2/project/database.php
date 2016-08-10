<?php
/* *******************************************************************
* filename : project/database.php
* author : Jon Benson
* username : jmbenso2
* course : cis355
* section : 31-MW
* semester : Summer 2016
*
* PURPOSE : 	Provides functions for connecting and disconnecting to database
*							using mysqli.
*
* *******************************************************************
*/
// connection constants
	define('DBHOST', 'localhost'); 
	define('DBNAME', 'jmbenso2'); 
	define('DBUSER', 'jmbenso2'); 
	define('DBPASS', '540550'); 

class Database 
{
	private static $cont  = null;
	
	public function __construct() {
		exit('Init function is not allowed');
	}
	
	public static function connect() {
			// turn on mysqli error reporting
			mysqli_report(MYSQLI_REPORT_STRICT);
		
	   // One connection through whole application
      if ( null == self::$cont ){      
				self::$cont =  mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME); 
				$error = mysqli_connect_error(); 
      } 
       
			if ($error != null) { // If there was an error
				die($error); 
			}
			else return self::$cont;
	}
	
	public static function disconnect() {
		mysqli_close(self::$cont);
		self::$cont = null;
	}
}
?>