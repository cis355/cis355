<?php
session_start();
// Store Session Data
if (empty($_SESSION['name'])) header("Location: loginelite.php"); //redirect
$name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the follwing.
		1. Sets character set
		2. Includes bootstrap
		-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body style="background-image: url('http://www.publicdomainpictures.net/pictures/40000/velka/grass-1366796906dab.jpg');">
	<!-- The head section does the follwing.
		1. Displays Heading
		2. Displays Create button
		3. Displays rows of database records
		4. Displays Toturial button
		-->
    <div class="container">
    		<div class="row">
    			<a href="http://www.auplod.com/i-poldau82986.html"><img src="http://www.auplod.com/u/poldau82986.png" alt="Image" border="0" /></a>
    		</div>
			<div class="row">
			<p>
				<p>
				   <a href="logoutelite.php" class="btn btn-danger">Logout <?php print[$name] ?> </a>
				</p>
			</p>
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Service</th>
						  <th>Description</th>
		                  <th>Price</th>
		                  <th>Date</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					  # database.php contains connection code,
					  # including connect and disconnect functions
					   include 'elitedatabase.php';
					   #connecting to the database and assign object to variable
					   $pdo = Database::connect();
					   # assign select statement to a variable
					   $sql = 'SELECT * FROM `contracts` INNER JOIN `services` INNER JOIN `customers` WHERE services.id = contracts.serviceID AND customers.id = contracts.customerID AND `name`= "chad"';
					   # itterates through every record returned by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['service_name'] . '</td>';
							   	echo '<td>'. $row['service_desc'] . '</td>';
							   	echo '<td>'. $row['service_price'] . '</td>';
								echo '<td>'. $row['service_date'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="paypal.php">
								<img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" align="left" style="margin-right:7px;"></a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
				<p>
					<a href="create.php" class="btn btn-success">New Service</a>
				</p>
    	</div>
    </div> <!-- /container -->
  </body>
</html>