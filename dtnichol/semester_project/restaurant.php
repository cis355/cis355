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

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
	1. Sets the character set 
	2. includes bootstrap-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="restaurantStyle.css">
</head>
<style>

</style>
<body>
	<div id="background"><img class="stretch" src="cityscape.jpg"/></div>
	<p>
		<a href="logout1.php" class="btn btn-danger">Logout</a>
	</p>	
	<p>
		<a href="index1.php" class="btn btn-success">Customers List</a>
	</p>
<?php
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

?>
<?php
require ("database.php");


class Customer {
	private static $id;
	private static $name;
	private static $email;
	private static $mobile;
	
	
	
	
	
	public function displayRecords () {
		$pdo = Database::connect();
		$sql = 'SELECT * FROM restaurant WHERE 1';
		
		echo '<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
						  <!--th>image</th-->
		                  <th>Name</th>
		                  <th>Address</th>
						  <th>Location</th>
						  <th>Type</th>
						  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>';
			
			
		
		;
		   foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						//echo '<td>';
						//echo "<img src='Image/" . $row['imageLink']"'/>";
						echo '<td>'. $row['venueName'] . '</td>';
						echo '<td>'. $row['address'] . '</td>';
						echo '<td>';
						echo '<a href='. $row['map'] . '>Map</a>';
						echo '<td>'. $row['type'] . '</td>';
						
						echo '<td width=250>';
						//echo '<a class="btn" href="read1.php?id='.
						//$row['id'].'">Read</a>';
						echo '&nbsp;';
						//echo '<a class="btn btn-success" 
						//href="update.php?id='.$row['id'].'">Update</a>';
						echo '&nbsp;';
						//echo '<a class="btn btn-danger" 
						//href="delete.php?id='.$row['id'].'">Delete</a>';
						echo '&nbsp;';
						echo '<a class="btn" href="createRating.php?id='.$row['id'].'">Rate and Review Me</a>';
						echo '</td>';
						echo '</tr>';
		}
					   echo '</tbody></table>';
					   echo '<h1>Ratings and Reviews</h1>';
						echo '<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Entertainment Venue</th>
		                  <th>Customer</th>
						  <th>Rating</th>
						  <th>Review</th>
		                </tr>
		              </thead>
		              <tbody>';




					   $sql = 'SELECT * FROM `ratings1` INNER JOIN `restaurant` INNER JOIN `customers1` WHERE restaurant.id = ratings1.restaurantID AND customers1.id = ratings1.customers1ID';
					   //iterates through every record return by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	//echo '<td>'. $row[0] . '</td>';
							   	echo '<td>'. $row['venueName'] . '</td>';
							   	echo '<td>'. $row['name'] . '</td>';							   							
							   	echo '<td>'. $row['rating'] . '</td>';
								echo '<td>'. $row['review'] . '</td>';
							   	echo '</tr>';
					   }
					   while($row = mysql_fetch_array($query))
						{
						echo '<img src="data:image/png;base64,' . base64_encode($row['content']) . '" />';
						}
					   
					   Database::disconnect();
		
	}
	
	
	
	
	

	
	
}

$cust1 = new Customer;
echo "<h1>Entertainment Venues</h1><br />";
//$cust1->displayCustomers();
$cust1->displayRecords();



echo "<br />";
//print_r($_SESSION);



?>

</body>
</html>