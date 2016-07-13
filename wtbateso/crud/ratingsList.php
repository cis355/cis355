<?php
	session_start();
	if (empty($_SESSION['name'])) header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
		1. Sets character set
		2. Includes bootstrap
		-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- The head section does the following.
		1. Displays heading
		2. Displays a "create button"
		3. Displays rows of database records (from MySQL database)
		4. Displays "tutorial" button
		-->
    <div class="container">
    		<div class="row">
    			<h3>Ratings of Products By Customers</h3>
    		</div>
			<div class="row">
				
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
					   # database.php contains connection code, including connect and disconnect funtions
					   include 'database.php';
					   # connect to database and assign object to variable
					   $pdo = Database::connect();
					   # assign select statement to variable
					   $sql = 'SELECT * FROM `ratings` INNER JOIN `product` INNER JOIN `customers2` WHERE 
					   product.id = ratings.productID and customers2.id = ratings.customerID';
					   # iterates through every record, return by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['0'] . '</td>';
							   	echo '<td>'. $row['productName'] . '</td>';
							   	echo '<td>'. $row['name'] . '</td>';
								echo '<td>'. $row['rating'] . '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
				<a href="http://www.startutorial.com/articles/view/php-crud-tutorial-part-1" class="btn btn-success">Tutorial</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>