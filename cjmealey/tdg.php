<?php
require ("crud/database.php");
session_start();

class Customer {

	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	private static $deleteFreds;
	
	public function insertFred () {
	
		$name = "Fred";
		$email = "fred@fred.com";
		$mobile = "123.456.7890";
	
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO customers (name,email,mobile) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile));
		Database::disconnect();
		// header("Location: tdg.php");
	
	}
	
	public function displayRecords () {
	
		$pdo = Database::connect();
		$sql = 'SELECT * FROM customers ORDER BY id DESC';
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
		
		foreach ($pdo->query($sql) as $row) {
			echo '<tr>';
			echo '<td>'. $row['name'] . '</td>';
			echo '<td>'. $row['email'] . '</td>';
			echo '<td>'. $row['mobile'] . '</td>';
			echo '<td width=250>';
			echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>';
			echo '&nbsp;';
			if ($_SESSION['empl_id'] == $row['employer_id']) {
				echo '<a class="btn btn-success" 
				   href="update.php?id='.$row['id'].'">Update</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-danger" 
				   href="delete.php?id='.$row['id'].'">Delete</a>';
			}
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		Database::disconnect();
	}

	
	function __construct () {
	
		$deleteFreds = $_GET['deleteFreds'];
	
	}
	

	function displayCreateButton(){
		echo "<a href='create.php' class='btn btn-success'>Create</a>";
	}

}

$cust1 = new Customer;
$cust1->displayCreateButton();
$cust1->displayRecords();
if ($_GET['empl_id'] == 1) $cust1->login(1);
if ($_GET['empl_id'] == 2) $cust1->login(2);

echo "<br /><br /><br />";
print_r ($_SESSION);
echo "<br /><br /><br />";











show_source(__FILE__);
?>