<?php
	// Redirect if not logged in
	session_start();
	if (empty($_SESSION['name'])) {
		header("Location: login.php"); // Redirect
	}
	// I want my baby back baby back baby back
	// I want my baby back baby back baby back
	// Chile's, baby back ribs
	// Holy crap WTF that's disturbing
	// "Baby back"????
	// WTF?
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- This head does the following: sets character set, includes link to bootstrap and JavaScript-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- -->
    <div class="container">
			<!-- Heading -->
    		<div class="row">
    			<h3>Product Ratings by REAL CUSTOMERS</h3>
    		</div>
			<div class="row">
				
				<!-- Data table: displays data from customers table in database -->
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
					   include 'database.php'; //including our database.php file
					   $pdo = Database::connect(); // Creating connection (PDO) object, named $pdo
					   
					   // Assign sql string to $sql
					   $sql = 'SELECT r.id, p.productName, c.name, r.rating FROM `ratings` AS r JOIN `customers` AS c ON r.customerID = c.id JOIN `product` AS p ON r.productID = p.id';
						
					   // Construct table body by writing HTML with data from database
					   
	 				   foreach ($pdo->query($sql) as $row) { // send query via the connection represented by $pdo
															 //   the query being sent is $sql
															 //   as $row -- as you iterate through, the current row will be named $row
															 //   Now we iterate through the rows selected
						   		echo '<tr>';
							   	echo '<td>'. $row['id'] . '</td>';
							   	echo '<td>'. $row['productName'] . '</td>';
							   	echo '<td>'. $row['name'] . '</td>';
								echo '<td>'. $row['rating'] . '</td>';
							   	echo '<td width="250">';
							   	echo '</td>';
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