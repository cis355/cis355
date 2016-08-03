<!--/* *******************************************************************
* filename : Program1.php
* author : Derek Nichols
* username : gpcorser
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program allows you to create, read, update, and delete from the customers 
				database we created in PHPMyAdmin.
				Class Customer contains the functions to display records which will also generate the html to form
				the table style look for the customers in the database.
				There is also the function for the create button that links to the create.php file.
				Then outside of the class is the php that calls the functions in the class Customer
*
* 
* *******************************************************************
*/-->




<?php
require ("database.php");


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
						echo '<td>'. $row['address'] . '</td>';
						echo '<td>'. $row['lat'] . '</td>';
						echo '<td>'. $row['lng'] . '</td>';
						echo '<td>'. $row['type'] . '</td>';
						echo '<td width=350>';
						echo '<a class="btn" href="read.php?id='.
						$row['id'].'">Read</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-success" 
						href="update.php?id='.$row['id'].'">Update</a>';
						echo '&nbsp;';
						echo '<a class="btn btn-danger" 
						href="delete.php?id='.$row['id'].'">Delete</a>';
						echo '&nbsp;';
						echo '<a class="btn" href="ratingsList.php?id='.$row['id'].'">Rate</a>';
						echo '</td>';
						echo '</tr>';
					   }
					   echo '</tbody></table>';
					   
					   Database::disconnect();
		
	}
	
	
	
	
	function displayCreateButton(){
		echo "<a href='create.php?create=yes' class='btn'>Create New Record</a><br />";
		
	}

	
	
}

$cust1 = new Customer;
echo "<h1>Object-Oriented CRUD Application</h1><br />";
$cust1->displayCreateButton();
$cust1->displayRecords();



echo "<br />";
//print_r($_SESSION);



?>