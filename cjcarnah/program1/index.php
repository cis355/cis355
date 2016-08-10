<?php

session_start();
header("Location: program1.php");
	
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
    			<h3>PHP CRUD Grid</h3>
    		</div>
			<div class="row">
				<p>
					<a href="create.php" class="btn btn-success">Create</a>
					<a href="login.php" class="btn btn-danger">Log Out</a>
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
					   # database.php contains connection code, 
					   # including connect and disconnect functions
					   include 'database.php';
					   $pdo = Database::connect();
					   $sql = 'SELECT * FROM customers ORDER BY id DESC';
					   # iterates through every record returned in the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['name'] . '</td>';
							   	echo '<td>'. $row['email'] . '</td>';
							   	echo '<td>'. $row['mobile'] . '</td>';
							   	echo '<td width="250">';
							   	echo '<a class="btn" href="read.php?id='.
								   $row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="delete.php?id='.$row['id'].'">Delete</a>';
							   	echo '</td>';
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
