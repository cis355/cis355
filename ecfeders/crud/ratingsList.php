<?php
	session_start();
	if(empty($_SESSION['name'])) header("Location: login.php"); // redirect 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following 
		1. Sets character set
		2.Includes bootstrap!-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- The body section does the following 
		1. Displays Heading
		2. Displays the create button
		3. Displays rows of database records from MYSQL
		4. Displays the tutorial button-->
    <div class="container">
    		<div class="row">
    			<h3>Ratings Of Products By Customers</h3>
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
					   # databse.php contains connection code including connect and disconnect
					   # functions
					   include 'database.php';
					   # connecting to the database and assign object to variable
					   $pdo = Database::connect();
					   # assigning variable for the SELECT STATEMENT
					   $sql = 'SELECT * FROM `ratings` INNER JOIN `products` INNER JOIN `customers` 
					          WHERE products.id = ratings.productID AND customers.id = ratings.customerID';
					   # iterates through every record return by the select statment above
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
				<a href="http://www.startutorial.com/articles/view/php-crud-tutorial-part-1" class="btn btn-success">Tutorial</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>