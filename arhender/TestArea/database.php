<?php
class Database
{
    private static $dbName = 'arhender' ;
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
	
	public function insertrecord($TableName)
	{
		
		if (!empty($_POST)){
			$place_holders = implode(',', array_fill(0, count($_POST), '?'));
			$arr_keys = array_keys($_POST);
		    $StrParams = implode(',',$arr_keys);
			$Values = implode(',',$_POST);
			
			
			
			$pdo = Self::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO " . $TableName . " (" . $StrParams . ") values(" . $place_holders . ")";
			#$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(explode(',',$Values));
			#$q->execute(array($name,$email,$mobile));
			Self::disconnect();
			
		}
		
	}
	
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
	
	public function GrabProfileInfo($name, &$Login)
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
	
	
	public function GenerateList($LoginType,$ListType, $name)
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
			$q = $pdo->prepare($sql); 
            $q->execute(array($Tuid['Tuid']));
			
			$Relationships = $q->fetchall();
            #$Relationships = $q->fetch(PDO::FETCH_ASSOC);
			#Select Students.Username, Students.FirstName, Students.LastName from Connections inner join Students on Connections.StudTuid = Students.Tuid and Connections.MentorTuid = ?;
			$pdo = self::disconnect(); 
			
			
			
			return $Relationships;
	}
		
	
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
		

    }
?>