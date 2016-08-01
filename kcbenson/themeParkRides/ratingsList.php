<?php
	session_start();
	if(empty($_SESSION['email'])) {
		header("Location: login.php"); //redirect
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following: 
		1. Sets the character set
		2. includes Bootstrap
		-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
<!-- The body section does the following: 
		1. Displays heading
		2. Displays "create" button
		3. Displays rows of database records (from MySQL database)
		4. Displays "tutorial" button
		-->
    <div class="container">
    		<div class="row">
    			<h3>Ratings of Rides by Riders</h3>
    		</div>
			<div class="row">
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Ride</th>
		                  <th>Ride Image</th>
		                  <th>Ride Type</th>
		                  <th>Park</th>
		                  <th>Rider</th>
		                  <th>Rating</th>
		                  <th>Comments</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   # database.php contains connection code, including connect and disconnect functions
					   include 'database.php';
					   # connect to database and assign object to a variable
					   $pdo = Database::connect();
					   # assign select statement to variable
					   $sql = 'SELECT * FROM `parkRatings` INNER JOIN `parkRides` INNER JOIN `parkCustomers` WHERE `parkRides`.id = `parkRatings`.rideID AND `parkCustomers`.id = `parkRatings`.customerID';
					   # iterates through every record returned by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['rideName'] . '</td>';
							   	echo '<td>'. $row['content'] . '</td>';
							   	echo '<td>'. $row['rideType'] . '</td>';
							   	echo '<td>'. $row['parkName'] . '</td>';
							   	echo '<td>'. $row['fName'] . ' ' . $row['lName'] . '</td>';
								echo '<td>'. $row['rating'] . '</td>';
								echo '<td>'. $row['justification'] . '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>