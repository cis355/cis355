<?php
/* *******************************************************************
 filename     : database.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains the class for connecting to the database, and the functions for
				create, read, update, and delete for the Mentors, Students, and connections table
*********************************************************************  */
class Database
{
    private static $dbName = 'arhender' ; #database connection values
    private static $dbHost = 'localhost' ;
    private static $dbUsername = 'arhender';
    private static $dbUserPassword = '530612';
     
    private static $cont  = null;
     
    public function __construct() {
        die('Init function is not allowed');
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
/*************************************************************		
FUNCTION: createrecord
Parameters   :  $TableName: Table to create in,          String
				
purpose       : The purpose of this function is to create a record
				in the specified database from what is posted in the Post array
				
output        : a record in a table of the arhender database
precondition  : $_POST array must have values that align with with attributes of the specified table
				and the names of what is posted must match the names of the columns
postcondition : may have to clear the post array
****************************************************************/
	public function createrecord($TableName)
	{
		
		if (!empty($_POST)){
			#if the post isn't empty create a string that has a number of question marks that match number of
			#parameters  of the sql query
			$place_holders = implode(',', array_fill(0, count($_POST), '?'));
			
			#place all the array keys from the post array into the $arr_keys, these are the value names to be inserted
			$arr_keys = array_keys($_POST);
			
			#transform the keys into a string that is delimited by commas
		    $StrParams = implode(',',$arr_keys);
			
			#do the same thing with the values that were posted
			$Values = implode(',',$_POST);
			
			
			
			$pdo = Self::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO " . $TableName . " (" . $StrParams . ") values(" . $place_holders . ")";
			#$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(explode(',',$Values)); #explode out all the values in array seperated by 
			#$q->execute(array($name,$email,$mobile));
			Self::disconnect();
			
		}
		
	}

/*************************************************************		
FUNCTION: login
Parameters   :  $LoginTable- table to login with,      string
				$name- username,					   string
				$password-password,                    string
				
purpose       : The purpose of this function is to return true or false
				if the login credentials are valid
				
output        : true/false
precondition  : to return true the username and password must be valid, 
postcondition : username must be unique
****************************************************************/
	public function login($LoginTable, $name, $password)
	{
		
		    $pdo = self::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "SELECT * FROM " . $LoginTable . " WHERE Username = ? LIMIT 1"; 
            $q = $pdo->prepare($sql); 
            $q->execute(array($name)); 
            $results = $q->fetch(PDO::FETCH_ASSOC); 
            if($results['Password']==$password) 
			{ 
				
                self::disconnect();
				$returnval = true;
				return $returnval;
			} 
            else 
			{ 
                self::disconnect(); 
				$returnval = false;				
				return $returnval;
            } 
		
	}
	
/*************************************************************		
FUNCTION: readuser
Parameters   :  $name- username				string		   
				$Login- table to query      string
					
				
purpose       : The purpose of this function is return the record and values
				of the requested user, and the login is returned if passed in
				
output        : values from either mentors or students
precondition  : username must be valid in mentors or username
postcondition : does not contain logintype must be brought in from lookupuser
****************************************************************/
	public function readuser($name, &$Login=null)
	{
			
			$results= self::lookupuser($name);
			$Login = $results['ProfileType'];
			
			
			
		    $pdo = self::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $sql = "SELECT * FROM " . $Login . " WHERE Username = ? LIMIT 1"; 
            $q = $pdo->prepare($sql); 
            $q->execute(array($name)); 
            $results = $q->fetch(PDO::FETCH_ASSOC); 
			$pdo = self::disconnect(); 
			return $results;
	}
	
	/*************************************************************		
FUNCTION: readconnections
Parameters   :  $Login- table to query             string
				$ListType- Opposite of $Login      string
				$name- username				       string
				$Active- if connection is active   string
				
purpose       : The purpose of this function is return the related
				active or inactive connections to the user passed 
				
output        : relationship list
precondition  : connections must be in table connections to return anything
postcondition : returns either active or not active
****************************************************************/
	public function readconnections($LoginType,$ListType, $name, $Active)
	{
		if($LoginType == "Mentors")
		{
			$LookupType = "StudTuid";
			$PersonalType = "MentorTuid";
			
		}
		else
		{
			$LookupType = "MentorTuid";
			$PersonalType = "StudTuid";
			
		}
		
		   #grab the user tuid of the user
		    $pdo = self::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $sql = "SELECT Tuid FROM ". $LoginType . " WHERE Username = ? LIMIT 1";			
            $q = $pdo->prepare($sql); 
            $q->execute(array($name)); 
            $Tuid = $q->fetch(PDO::FETCH_ASSOC);
			$pdo = self::disconnect(); 
			
		
			#use the user tuid to read all connections where the studtuid or mentortuid match in the connections table
			$pdo = self::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "Select Connections.ConnectionTuid, " . $ListType .".ProfilePicture, " . $ListType . ".Username, " . $ListType . ".FirstName, " . $ListType . ".LastName from Connections inner join " . $ListType . " on Connections." . $LookupType . "=" . $ListType . ".Tuid and Connections." . $PersonalType . "=? where Connections.Active =" .  $Active;
			#$sql = "Select ". $ListType .".ProfilePicture, " . $ListType . ".Username, " . $ListType . ".FirstName, " . $ListType . ".LastName from Connections inner join " . $ListType . " on Connections." . $LookupType . "=" . $ListType . ".Tuid and Connections." . $PersonalType . "=?";
			$q = $pdo->prepare($sql); 
            $q->execute(array($Tuid['Tuid']));
			
			$Relationships = $q->fetchall();
            #$Relationships = $q->fetch(PDO::FETCH_ASSOC);
			#Select Students.Username, Students.FirstName, Students.LastName from Connections inner join Students on Connections.StudTuid = Students.Tuid and Connections.MentorTuid = ?;
			$pdo = self::disconnect(); 
			
			
			
			return $Relationships;
	}
		
/*************************************************************		
FUNCTION: lookupuser
Parameters   :  $name, username           string
				
purpose       : The purpose of this function is return the related
				username and also the login type they are
				
output        : record from lookup table
precondition  : username must exist in lookup table
postcondition : username may return nothing if username doesnt exist
****************************************************************/	
	public function lookupuser($name){
		$pdo = self::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $sql = "SELECT * FROM Lookup WHERE Username = ? LIMIT 1"; 
            $q = $pdo->prepare($sql); 
            $q->execute(array($name)); 
            $results = $q->fetch(PDO::FETCH_ASSOC); 
			$pdo = self::disconnect(); 
		
		    return $results;
		
	}

/*************************************************************		
FUNCTION: readallconnections
Parameters   :  $Login- table to query             string
				$ListType- Opposite of $Login      string
				$name- username				       string
				
				
purpose       : The purpose of this function is return the all related
				active and inactive connections to the user passed 
				
output        : relationship list
precondition  : connections must be in table connections to return anything
postcondition : returns either active or not active
****************************************************************/
		public function readallconnections($LoginType,$ListType, $name)
	{
		if($LoginType == "Mentors")
		{
			$LookupType = "StudTuid";
			$PersonalType = "MentorTuid";
			
		}
		else
		{
			$LookupType = "MentorTuid";
			$PersonalType = "StudTuid";
			
		}
		
		
		    $pdo = self::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $sql = "SELECT Tuid FROM ". $LoginType . " WHERE Username = ? LIMIT 1";			
            $q = $pdo->prepare($sql); 
            $q->execute(array($name)); 
            $Tuid = $q->fetch(PDO::FETCH_ASSOC);
			$pdo = self::disconnect(); 
			
		
			
			$pdo = self::connect(); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$sql = "Select ". $ListType .".ProfilePicture, " . $ListType . ".Username, " . $ListType . ".FirstName, " . $ListType . ".LastName from Connections inner join " . $ListType . " on Connections." . $LookupType . "=" . $ListType . ".Tuid and Connections." . $PersonalType . "=?";
			#$sql = "Select ". $ListType .".ProfilePicture, " . $ListType . ".Username, " . $ListType . ".FirstName, " . $ListType . ".LastName from Connections inner join " . $ListType . " on Connections." . $LookupType . "=" . $ListType . ".Tuid and Connections." . $PersonalType . "=?";
			$q = $pdo->prepare($sql); 
            $q->execute(array($Tuid['Tuid']));
			
			$Relationships = $q->fetchall();
            #$Relationships = $q->fetch(PDO::FETCH_ASSOC);
			#Select Students.Username, Students.FirstName, Students.LastName from Connections inner join Students on Connections.StudTuid = Students.Tuid and Connections.MentorTuid = ?;
			$pdo = self::disconnect(); 
			
			
			
			return $Relationships;
	}
	

/*************************************************************		
FUNCTION: updateconnection
Parameters   :  $id, connectionid           integer
				
purpose       : The purpose of this function is to update the connection record
				that has the id passed in to make the connection active
				
output        : updated record in connections table
precondition  : connection must exist in the 
postcondition : active for the record is set to 1 or true
****************************************************************/		
		public function updateconnection($id)
		{
			
			$pdo = self::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Connections set Active= 1 WHERE ConnectionTuid = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($id));
			self::disconnect();
			
			
		}

/*************************************************************		
FUNCTION: updateuser
Parameters   :  $LoginType- Login table,    string
				$id, connectionid           integer
				$name, username				string
				
purpose       : The purpose of this function is to update the user record
				of the username passed in within the table, having the id passed in
				
output        : updated user in mentors/students table
precondition  : user must exist in either table
postcondition : all values are changed based on $_POST values passed in
****************************************************************/		
		public function updateuser($LoginType, $id, $name)
		{
			
			
			
			$username = $_POST['Username'];
			$password = $_POST['Password'];
			$firstname = $_POST['FirstName'];
			$lastname = $_POST['LastName'];
			$age = $_POST['Age'];
			$Education = $_POST['EducationLevel'];
			$Bio = $_POST['bio'];
			$City = $_POST['City'];
			$State = $_POST['ProvinceOrState'];
			$Country = $_POST['Country'];
			
			$oldinfo = self::lookupuser($name);
			$tuid = $oldinfo['Tuid'];
			
			
			$pdo = self::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE Lookup SET Username= ? WHERE Tuid= ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($username,$tuid));
			self::disconnect();
	   
	       
       
			#use as template 
			$pdo = self::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			$sql = "UPDATE ". $LoginType . " SET Username= ?, Password=?,FirstName=?, LastName=?, Age=?, EducationLevel=?, Bio=?, City=?, ProvinceOrState=?, Country=? WHERE Tuid = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($username, $password, $firstname, $lastname, $age, $Education, $Bio, $City, $State, $Country, $id));
			
			self::disconnect();
			
			
					
		}
		
/*************************************************************		
FUNCTION: deleteconnection
Parameters   :  $id-connectionid,           integer
				
purpose       : The purpose of this function is to delete the record
				in the connections table with id passed in
				
output        : deleted record
precondition  : connection must exist
postcondition : connection will no longer be available
****************************************************************/			
		public function deleteconnection($id)
		{
		$pdo = self::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Connections WHERE ConnectionTuid = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		self::disconnect();	
	   }
	   
/*************************************************************		
FUNCTION: deleterelatedconnection
Parameters   :  $LoginType- login table,          string
				$id- userid,                      integer
				
purpose       : The purpose of this function is to delete all records
				in the connections table with the user id passed in
				
output        : deleted records
precondition  : user must have existing connections
postcondition : connections will no longer be available
****************************************************************/	
	   public function deleterelatedconnections($LoginType, $id)
	   {
		   
		 if($LoginType== "Students"){
			 
			 $tuidtype = "StudTuid";
			 
		 }
		 else{
			 
			 $tuidtype = "MentorTuid";
		 }
		 
		
		$pdo = self::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Connections WHERE ".$tuidtype ." = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		self::disconnect();	
		
	   }

/*************************************************************		
FUNCTION: deleteuser
Parameters   :  $LoginType- table to delete from     string
				$id-userid,                          integer
				$name-username                       string
				
purpose       : The purpose of this function is to delete the record
				in the appropriate table with id passed in
				
output        : deleted record from either students or mentors
precondition  : user must exist
postcondition : User will no longer be available
****************************************************************/			   
	   public function deleteuser($LoginType, $id, $name){
		   
		$pdo = self::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM " . $LoginType . " WHERE Tuid = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		self::disconnect();	
		 
	   }

/*************************************************************		
FUNCTION: deletelookup
Parameters   :  $id-lookupid,                          integer
				
				
purpose       : The purpose of this function is to delete the record
				in the lookup table with id passed in
				
output        : deleted record from lookup table
precondition  : lookup record must exist
postcondition : lookup will no longer be available for deleted record
****************************************************************/	
	   public function deletelookup($id){
		   
		$pdo = self::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM Lookup WHERE Tuid = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		self::disconnect();	
		   
		   
		   
	   }
	   
	

    }
?>