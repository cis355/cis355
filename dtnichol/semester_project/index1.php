<?php
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

function login ($empl_id){
		$_SESSION['id'] = $empl_id;
		
	}

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
	1. Sets the character set 
	2. includes bootstrap-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- The body section does the following.
	1. Displays heading
	2. Displays a "create" button
	3. Displays rows of a database record (from MySql database)
	4. Displays "tutorial Button"-->
    <div class="container">
    		<div class="row">
    			<h3>Customers List</h3>
    		</div>
			<div class="row">
				<p>
					<!--a href="create1.php" class="btn btn-success">Create</a-->
					<a href="logout1.php" class="btn btn-danger">Logout</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Email Address</th>
		                  <th>Mobile Number</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					  //database.php contains connection code, including connect and disconnect functions
					   include 'database.php';
					   //connect to database and assign object to variable
					   $pdo = Database::connect();
					   
					   //assign select statement to variable
					   $sql = 'SELECT * FROM customers1 ORDER BY id DESC';
					   //iterates through every record return by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['mobile'] . '</td>';
							   	echo '<td width=350>';
							   	echo '<a class="btn" href="readCustomer.php?id='.
								   $row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	if ($_SESSION['id'] == $row['id']) {
									echo '<a class="btn btn-success" 
									href="update1.php?id='.$row['id'].'">Update</a>';
									echo '&nbsp;';
									echo '<a class="btn btn-danger" 
									href="delete1.php?id='.$row['id'].'">Delete</a>';
								}
								echo '&nbsp;';
								echo '<a class="btn" href="ratingsList1.php?id='.$row['id'].'">Rate</a>';
							   	
								echo '</td>';
							   	echo '</tr>';
					   }
					   
					   Database::disconnect();
					   
					  ?>
				      </tbody>
					  
	            </table>
				<a href="restaurant.php" class="btn btn-success">Entertainment Venues List</a>
				
    	</div>
    </div> <!-- /container -->
	<div>
	
	</div>
  </body>
</html>