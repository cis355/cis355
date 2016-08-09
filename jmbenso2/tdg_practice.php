<?php
session_start();
require("crud/database.php");

class Customer {
	# Member data -- class data, not instance data
	private static $id; # int
	private static $name; # varchar / String
	private static $email; # varchar / String
	private static $mobile; # varchar / String
	private static $password; # varchar / String
	
	# Member functions
	public function insertFred () {
		
		$name = "Fred";
		$email = "fred@fred.net";
		$mobile = "9896894837";
		
		$pdo = Database::connect(); // Connect to database, reference in $pdo variable
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set attributes of connection
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile));
		Database::disconnect();
	}
	
	public function displayRecords () {
		
		$pdo = Database::connect(); // Creating connection (PDO) object, named $pdo
		$sql = 'SELECT * FROM customers ORDER BY id DESC'; // Assign sql string to $sql
		// Construct table body by writing HTML with data from database
		
		echo '<table><tr><th>Name</th><th>Email</th><th>Mobile</th><th>Actions</th></tr>';
					   
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
			if ($_SESSION['empl_id'] == $row['employer_id']) {
				echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
			}
			echo '</td>';
			echo '</tr>';
			
		}
		echo '</table>';
		Database::disconnect();
	}
	
	public function deleteFred() {
		
		$name = "Fred";
		
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM customers WHERE name=?";
		$q = $pdo->prepare($sql);
		$q->execute(array($name));
		Database::disconnect();
	}
	
	public function displayFredButton() {
		echo "<a class='btn btn-danger' href='tdg.php?deleteFreds=yes'>Delete All Freds</a><br />";
	}
	
	public function displayLoginButtons() {
		echo "<a class='btn btn-success' href='tdg.php?empl_id=1'>Login as 1</a><br />";
		echo "<a class='btn btn-success' href='tdg.php?empl_id=2'>Login as 2</a><br />";
	}
	
	public function login($empl_id) {
		$_SESSION['empl_id'] = $empl_id;
	}

	
}
$fred = new Customer();
$fred->displayLoginButtons();
$fred->displayFredButton();
if ($_GET['deleteFreds'] == 'yes') {
	$fred->deleteFred();
	header("Location: tdg.php");
}
if ($_GET['empl_id'] == 1) {
	$fred->login(1);
	header("Location: tdg.php");
}
if ($_GET['empl_id'] == 2) {
	$fred->login(2);
	header("Location: tdg.php");
}
$fred->displayRecords();
print_r($_SESSION);

?>