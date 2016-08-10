<?php

require ("crud/database.php");

class Customer {
	
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	
	public function insertFred(){
		
		$name = "Fred";
		$email = "fred@fred.fred";
		$mobile = "123-fred";
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile));
		Database::disconnect();
		//header("Location: tdg.php");
		
	}
	
	public function displayRecords(){
		echo '<table class="table table-striped table-bordered">
		        <thead>
		          <tr>
		            <th>Name</th>
		            <th>Email Address</th>
		            <th>Mobile Number</th>
		            <th>Action</th>
		          </tr>
		        </thead>
		        <tbody>';
				
		# database.php contains connection code, including connect and disconnect functions
		include 'database.php';
		# connect to database and assign object to variable
		$pdo = Database::connect();
		# assign select statement to variable
		$sql = 'SELECT * FROM customers ORDER BY id DESC';
		# iterates through every record return by the select statement
	 	foreach ($pdo->query($sql) as $row) {
			echo '<tr>';
			echo '<td>'. $row['name'] . '</td>';
			echo '<td>'. $row['email'] . '</td>';
			echo '<td>'. $row['mobile'] . '</td>';
			echo '<td width=250>';
			echo '<a class="btn" href="read.php?id='.
			$row['id'].'">Read</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-success" 
			href="update.php?id='.$row['id'].'">Update</a>';
			echo '&nbsp;';
			echo '<a class="btn btn-danger" 
			href="delete.php?id='.$row['id'].'">Delete</a>';
			echo '</td>';
			echo '</tr>';
		}
		Database::disconnect();
		echo '</tbody>
	            </table>';
	}
	
	function deleteAllFreds(){
		Database::connect();
		$name = 'Fred';
		$sql = "DELETE FROM customers WHERE name = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name));
		Database::disconnect();
	}
	
	function displayDeleteFredButton(){
		echo "<a href='tdg.php?deleteFreds=yes' class='btn btn-success'>DELETE ALL FREDS!!!</a><br />";
	}
}

$cust1 = new Customer;
$cust1->insertFred();
$cust1->displayDeleteFredButton();
if($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds();
$cust1->displayRecords();


show_source(__FILE__);

?>