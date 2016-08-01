<?php
	require("database.php");

/* class CustomerGateway()
 ***********************************************************
 *PURPOSE: Provides interface to the tdg_users table.
 **********************************************************/
class CustomerGateway {
	// Member data -- class data, not instance data
	private static $id; # int
	private static $name; # varchar / String
	private static $email; # varchar / String
	private static $mobile; # varchar / String
	
	/* create ($name,$email,$mobile)
	 ***********************************************************
	 *PURPOSE: Adds a record to the database table.
	 *INPUT: $name, $email, $mobile (containing strings)
	 *PRE: $email is a valid email address, $name and $mobile not null
	 *OUTPUT: N/A
	 *POST: New record in database table.
	 *NOTE:
	 **********************************************************/
	public function create($name,$email,$mobile) {
		//Precondition: email valid
		//				name, mobile not null
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set attributes of connection
		
		// SQL to execute:
		$sql = "INSERT INTO tdg_users (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile));
		Database::disconnect();
	} // End of create
	
	/* read ($id, &$data)
	 ***********************************************************
	 *PURPOSE: Reads a record in the database table.
	 *INPUT: $id (containing integer)
	 *PRE: $id corresponds to an existing record where $id = tdg_user.id
	 *OUTPUT: &$data
	 *POST: &$data is array of record's values
	 *NOTE:
	 **********************************************************/
	public function read ($id, &$data) {
		//Precondition: $ id not null
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM tdg_users where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
	
	/* update ($id,$name,$email,$mobile)
	 ***********************************************************
	 *PURPOSE: Updates a record in the database table.
	 *INPUT: $id (containing integer), $name $email $mobile (containing strings) 
	 *PRE: $id corresponds to an existing record where $id = tdg_user.id,
	 *		$email a valid email address, $name and $mobile not null
	 *OUTPUT: N/A
	 *POST: Record updated in database
	 *NOTE:
	 **********************************************************/
	public function update ($id,$name,$email,$mobile) {
		//Precondition: email valid
		//				id, name, mobile not null	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "UPDATE tdg_users  set name = ?, email = ?, mobile =? WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile,$id));
		Database::disconnect();
	}
	
	/* updateGetCurrentData ($id, &$name, &$email, &$mobile)
	 ***********************************************************
	 *PURPOSE: Reads a record in the database table prior to updating.
	 *INPUT: $id (containing integer)
	 *PRE: $id corresponds to an existing record where $id = tdg_user.id
	 *OUTPUT: &$name, &$email, &$mobile
	 *POST: Output arguments contain record's name, email and mobile from database table.
	 *NOTE:
	 **********************************************************/
	public function updateGetCurrentData ($id,&$name,&$email,&$mobile) {
		// This is for filling the Update page with the
		//  existing data, before new data is posted
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM tdg_users where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$name = $data['name'];
		$email = $data['email'];
		$mobile = $data['mobile'];
		Database::disconnect();
	} 
	
	/* delete ($id)
	 ***********************************************************
	 *PURPOSE: Deletes a record from the database table.
	 *INPUT: $id (containing integer)
	 *PRE: $id corresponds to an existing record where $id = tdg_user.id
	 *OUTPUT: N/A
	 *POST: Record of id $id no longer exists in database table.
	 *NOTE:
	 **********************************************************/
	public function delete ($id) {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM tdg_users  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
	}
	
	/* displayTable ()
	 ***********************************************************
	 *PURPOSE: Prints an HTML table containing all records in table.
	 *INPUT: N/A
	 *PRE: N/A
	 *OUTPUT: N/A
	 *POST: HTML table printed.
	 *NOTE:
	 **********************************************************/	
	public function displayTable () {
		// Echoes html for table containing customer data.
		
		$pdo = Database::connect();
		
		// SQL to execute:
		$sql = 'SELECT * FROM tdg_users ORDER BY id DESC';
		
		echo '<table><tr><th>Name</th><th>Email</th><th>Mobile</th><th>Actions</th></tr>'; // echo out table header
		
		foreach ($pdo->query($sql) as $row) { // send query via the connection represented by $pdo
			//   the query being sent is $sql
			//   as $row -- as you iterate through, the current row will be named $row
			//   Now we iterate through the rows selected
			echo '<tr>';
			echo '<td>'. $row['name'] . '</td>';
			echo '<td>'. $row['email'] . '</td>';
			echo '<td>'. $row['mobile'] . '</td>';
			echo '<td width="250">';
			echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
			echo '</td>';
			echo '</tr>';
		} // End of table drawing loop

			echo '</table>';
			Database::disconnect();
	} // End of displayTable
	
	/* isNewDataValid ($name, $email, $mobile, &$nameError, &$emailError, &$mobileError, &$valid)
	 ***********************************************************
	 *PURPOSE: Tests if all input data are valid.
	 *INPUT: $name, $email, $mobile
	 *PRE: N/A
	 *OUTPUT: &$nameError, &$emailError, &$mobileError, &$valid
	 *POST: &$nameError, &$emailError, and &$mobileError contain any error messages
	 *		&$valid contains true if all inputs valid, false otherwise
	 *NOTE:
	 **********************************************************/
	public function isNewDataValid($name,$email,$mobile,&$nameError,&$emailError,&$mobileError,&$valid) {
		// keep track of validation error messages and overall validity
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		$valid = true;
		
		if (empty($name)) { // If no name was read/posted
			$nameError = 'Please enter Name'; // Set name error message
			$valid = false; // If this is set to false anywhere, prevents us from inserting data later on
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address'; // If no email was read/posted
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) { // Or if email is invalid
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
	}
		
} // End of Class CustomerGateway
	/*
	
*/	


?>