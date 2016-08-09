<?php
require ("database.php");
session_start();

class Customer {

	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	
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
//			echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>';
            $this->displayRead($row);
			echo '&nbsp;';
			if ($_SESSION['empl_id'] == $row['employer_id']) {
				$this->displayUpdate($row);
				echo '&nbsp;';
				$this->displayDelete($row); 
			}
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		Database::disconnect();
	}
		
	function displayLoginButton () {
	
		echo "<a href='tdg.php?empl_id=1' class='btn btn-success'>Set Empl ID to One</a><br />";
	
	}
	
	function __construct () {
	
		$deleteFreds = $_GET['deleteFreds'];
	
	}
	
	function login ($empl_id) {
		$_SESSION['empl_id'] = $empl_id; 
	}

	public function displayCreateButton() {
		echo "<a href='create.php?create=yes' class='btn btn-success'>Create New Record</a><br />";
	}
    
    public function displayUpdate($row) {
        echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';
    }
    
    public function displayDelete($row) {
        echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
    }
	
    public function displayRead($row) {
        echo '<a class="btn" href="read.php?id='. $row['id'].'">Read</a>';
    }
}

$cust1 = new Customer;
echo "<br>Object-oriented CRUD Appliication<br />";
$cust1->displayCreateButton();
$cust1->displayRecords();


if ($_GET['empl_id'] == 1) $cust1->login(1);
if ($_GET['empl_id'] == 2) $cust1->login(2);
if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds();

echo "<br /><br /><br />";
print_r ($_SESSION);
echo "<br /><br /><br />";











show_source(__FILE__);
?>