<?php
  session_start();
  if(empty($_SESSION['name'])) header("Location: login.php"); //redirect
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
		1. Sets character set
		2. Includes Bootstrap
		-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- The body section does the following.
		1. Displays heading
		2. Displays a "create" button"
		3. Displays rows of database records (from MySQL database)
		4. Displays "tutorial" button
		-->
    <div class="container">
    		<div class="row">
    			<h3>PHP CRUD Grid</h3>
    		</div>
			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Create</a>
          <a href="logout.php" class="btn btn-danger">Logout</a>
				</p>
				
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
					   # database.php contains connection code, including connect and disconnect functions
					   include 'database.php';
					   # connect to database and assign object to variable
					   $pdo = Database::connect();
					   # assign select statement to variable
					   $sql = 'SELECT ratings.id, product.productName, customers.name, ratings.rating FROM `ratings` INNER JOIN `product` INNER JOIN `customers` WHERE product.id = ratings.productID AND customers.id = ratings.customerID';
					   # iterates through every record return by the select statement
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