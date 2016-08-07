<?php
/* *******************************************************************
 filename     : Customer.php  
 author       : Adam Henderson  
 username     : arhender 
 course       : cs355  
 section      : 11-MW  
 semester     : Summer 2016  
 description  : This file contains a class that allows a user to create, read, update
				and delete Customer records from a back-end database, as well as
				get and set variables within the class, and display all the records in
				a table format
*********************************************************************  */


require "database.php"; #for database connections and processing
class customer
{
	
	private $id; #private class variables
	private $name;
	private $email;
	private $phone;

/*************************************************************		
FUNCTION: __construct
Parameters   :  $fn- first name      			 Type: string
				$mail- email  		 			 Type: string
				$phonenum- phone number 		 Type: string
				
purpose       : The purpose of this function is to be parametrized
				constructor.
				
output        : An object of type customer 
precondition  : none, an object can be instantiated at any time.
postcondition : The object is as-is. 
****************************************************************/
	function __construct($fn=null, $mail=null, $phonenum=null) 
	{ 
		$this->id= 0;  #set all of the variables
        $this->name = $fn; 
        $this->email = $mail; 
        $this->phone = $phonenum;
         
    } 
	
/*************************************************************		
FUNCTION: setid
Parameters   :  $tuid- unique id 			Type: integer
				
purpose       : The purpose of this function is to set the id
				of the object
				
output        : object id is set to the passed tuid.
precondition  : an object is already instantiated 
postcondition : n/a 
****************************************************************/
	public function setid($tuid)
	{
		$this->id = $tuid; #set the id of the function
		
	}
	
/*************************************************************		
FUNCTION: getid
Parameters   :  n/a
				
purpose       : The purpose of this function is to return the id
				of the object
				
output        : object id is returned for use.
precondition  : an object is already instantiated 
postcondition : n/a 
****************************************************************/
	public function getid()
	{
		
	return $this->id;	#return object id
	}
	
	
/*************************************************************		
FUNCTION: getid
Parameters   :  n/a
				
purpose       : The purpose of this function is to return the name
				of the object
				
output        : object name is returned for use.
precondition  : an object is already instantiated 
postcondition : n/a 
****************************************************************/	
	public function getname()
	{
		
		return $this->name; #return name
	
	}
		

/*************************************************************		
FUNCTION: getphone
Parameters   :  n/a
				
purpose       : The purpose of this function is to return the phone number
				of the object
				
output        : object phone number is returned for use.
precondition  : an object is already instantiated 
postcondition : n/a 
****************************************************************/		
	public function getphone()
	{
		
	return $this->phone; #return phone
		
	}
	

	
/*************************************************************		
FUNCTION: getemail
Parameters   :  n/a
				
purpose       : The purpose of this function is to return the email
				of the object
				
output        : object email is returned for use.
precondition  : an object is already instantiated 
postcondition : n/a 
****************************************************************/	
	public function getemail()
	{
		
		
		return $this->email; #return email
		
	}

/*************************************************************		
FUNCTION: displayrecords
Parameters   :  n/a
				
purpose       : The purpose of this function is to display
				all customers in the database.
output        : a table containing the customer name, email, phone number and a button to allow for read
				update, and delete functionality
precondition  : an object is already instantiated, there are records in the database
postcondition : n/a 
****************************************************************/	
	public function displayrecords()
	{
		
		 # database.php contains connection code, including connect and disconnect functions
					   #include 'database.php';
					   # connect to database and assign object to variable
					   $pdo = Database::connect();
					   # assign select statement to variable
					   $sql = 'SELECT * FROM customers ORDER BY id DESC';
					   # iterates through every record return by the select statement
					   # and returns the properly formatted table with each column dedicated
					   #to a particular item
	 				   foreach ($pdo->query($sql) as $row) 
					   {
						   		echo '<tr>'; #for each record output and format
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['mobile'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn btn-primary" href="read.php?id='.
								  $row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="update.php?id='.$row['id'].'">Update</a>'; #place the id in the $_get array
							   	echo '&nbsp;';                                      #for processing use
							   	echo '<a class="btn btn-danger" 
								   href="delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect(); #disconnect from database
					   
	}
	
/*************************************************************		
FUNCTION: create
Parameters   :  n/a
				
purpose       : The purpose of this function is to insert a customer record into the database
output        : a new customer record in the database.
precondition  : an object is already instantiated, there is an existing database.
postcondition : n/a 
****************************************************************/		
	public function create()
	{
		    $pdo = Database::connect(); #connect
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)"; #set parametrized query
			$q = $pdo->prepare($sql); #prepare
			$q->execute(array($this->name,$this->email,$this->phone)); #execute query and insert
			Database::disconnect();
	
	}
/*************************************************************		
FUNCTION: read
Parameters   :  n/a
				
purpose       : The purpose of this function is to read a customer record from the database
output        : the variables are set inside the class to what is read in.
precondition  : an object is already instantiated, the id is already set for the object.
postcondition : the variables are set inside the class to what is read in.
****************************************************************/	
	public function read()
	{
		
		$pdo = Database::connect(); #connect
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers where id = ?"; #query for the current id which is set using setid
		$q = $pdo->prepare($sql); #prepare the sql
		$q->execute(array($this->id)); #execute
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
		
		$this->name = $data['name']; #set the internal object variables to the results.
		$this->email = $data['email'];
		$this->phone = $data['mobile'];
		
	}
	
/*************************************************************		
FUNCTION: update
Parameters   :  n/a
				
purpose       : The purpose of this function is to update a customer record in the database
output        : a record is updated in the database.
precondition  : an object is already instantiated, the record exists in the database, the attributes are set.
postcondition : the record is changed.
****************************************************************/	
	public function update()
	{
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE customers  set name = ?, email = ?, mobile =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($this->name,$this->email,$this->phone,$this->id));
			Database::disconnect();
	}
/*************************************************************		
FUNCTION: delete
Parameters   :  n/a
				
purpose       : The purpose of this function is to delete a customer record from the database
output        : a record is deleted from the database.
precondition  : an object is already instantiated, the record exists in the database, the id is set.
postcondition : the record is changed.
****************************************************************/		
	public function delete()
	{
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM customers  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($this->id));
		Database::disconnect();
		
	}
	
}







?>