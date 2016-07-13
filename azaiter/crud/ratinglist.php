<?php
session_start();
include 'database.php';
include("session.php"); 
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
    			<h3>Hello <?php echo $_SESSION["username"]; ?> !</h3>
    			<h3>Rating of products by id</h3>
    		</div>
			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>
				
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
					   //include 'database.php';
					   $pdo2 = Database::connect();
					   $sql2 = 'SELECT ratings.rating, ratings.id,customers.name,product.productName FROM ratings,customers,product
								where ratings.customerID = customers.id
								and ratings.productID = product.id';
	 				   foreach ($pdo2->query($sql2) as $row) {
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
				<a href="logout.php" class="btn btn-danger">Logout</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>