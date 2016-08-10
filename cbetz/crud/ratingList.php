<?php
session_start();
if (empty($_SESSION['name'])) header("Location: login.php"); //redirect
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

<body>
	<!-- The head section does the follwing.
		1. Displays Heading
		2. Displays Create button
		3. Displays rows of database records
		4. Displays Tutorial button
		-->
    <div class="container">
    		<div class="row">
    			<h3>Ratings of Products By Customers</h3>
    		</div>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Rating ID</th>
		                  <th>Product</th>
		                  <th>Customer</th>
		                  <th>Rating</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM `ratings` INNER JOIN `products` INNER JOIN `customers` WHERE products.id = ratings.productID AND customers.id = ratings.customerID';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row[0] . '</td>';
							   	echo '<td>'. $row['productName'] . '</td>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['rating'] . '</td>';
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