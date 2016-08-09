<?php
session_start();
//if (empty($_SESSION['name'])) header("Location: login.php"); // redirect

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    		<div class="row">
    			<h3>Ratings of Products By Customers</h3>
    		</div>
			<div class="row">
						
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Rating Id</th>
		                  <th>Product</th>
		                  <th>Customer</th>
		                  <th>Rating</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM `ratings` INNER JOIN `products` INNER JOIN `customers` WHERE products.id = ratings.productId AND customers.id = ratings.customerId';
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['id'] . '</td>';
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