<?php
//Define how the database connects
require ("CRUD/database.php");
session_start();

//Customer class is used to create and display user data
//and it contains data for users id, name, email, and mobile number
class Customer {

  //Member data for the customer class
  private static $id;
  private static $name;
  private static $email;
  private static $mobile;
	
  //Displays the records in the database in the form of a table
  //and displays CRUD buttons
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
			echo '<a class="btn btn-info" href="CRUD/read.php?id='. $row['id'].'">Read</a>';
			echo '&nbsp;';
			if ($_SESSION['empl_id'] == $row['employer_id']) {
				echo '<a class="btn btn-success" 
				   href="CRUD/update.php?id='.$row['id'].'">Update</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-danger" 
				   href="CRUD/delete.php?id='.$row['id'].'">Delete</a>';
			}
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
		Database::disconnect();
	}
	
  //Displays the login buttons
	function displayLoginButton () {
    echo "<a href='tdg.php?empl_id=1' class='btn btn-success'>Set Empl ID to One</a><br />";
	}
	//Default constructor
	function __construct () {
	
	}
	//logs in person with given id
	function login ($empl_id) {
		$_SESSION['empl_id'] = $empl_id;
	}
  //Displays the create button, links to create.php
  function displayCreateScreen(){
    echo "<a href='CRUD/create.php' class='btn btn-primary'>Create</a><br/>";
  }
}

//Header for the CRUD application
echo '<html lang="en">
        <head>
            <meta charset="utf-8">
            <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        </head>';
echo    '<body>';
//Create a new customer object
$cust1 = new Customer;
//Display the button to create a new users
$cust1->displayCreateScreen();
//Display the records
echo '<div class="container">';
  echo '<div class="panel panel-primary">';
    echo '<div class="panel-heading">Records Table</div>';
    echo '<div class="panel-body">';
      $cust1->displayRecords();
    echo '</div>';
  echo '</div>';
echo '</div>';

if ($_GET['empl_id'] == 1) $cust1->login(1);
if ($_GET['empl_id'] == 2) $cust1->login(2);
if ($_GET['deleteFreds'] == 'yes') $cust1->deleteAllFreds();

echo "<br/><br/><br/>";
print_r ($_SESSION);
echo "<br/><br/><br/>";
echo "<br/><br/>";
echo '</body>';
echo '</html>';
echo '<br/><br/><br/>';

show_source(__FILE__);
?>