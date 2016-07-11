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
    			<h3>PHP CRUD Grid</h3>
    		</div>
			<div class="row">
				<!-- Create button (opens create.php) -->
				<p>
					<a href="create.php" class="btn btn-success">Create</a>
				</p>
				
				<!-- Data table: displays data from customers table in database -->
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
					   include 'database.php'; //including our database.php file
					   $pdo = Database::connect(); // Creating connection (PDO) object, named $pdo
					   $sql = 'SELECT * FROM customers ORDER BY id DESC'; // Assign sql string to $sql
					   // Construct table body by writing HTML with data from database
					   
	 				   foreach ($pdo->query($sql) as $row) { // send query via the connection represented by $pdo
															 //   the query being sent is $sql
															 //   as $row -- as you iterate through, the current row will be named $row
															 //   Now we iterate through the rows selected
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