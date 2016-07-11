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
    			<h1><center>Elite Lawncare & Landscape</center></h1>
    		</div>
			<div class="row">
			<p>
				<h2> User Logged In </h2> 
				<p>
				  <button type="button" class="btn btn-default btn-sm">
				    <span class="glyphicon glyphicon-log-out"></span> Log out
				  </button>
				</p>
			</p>
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Service</th>
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
					   $sql = 'SELECT * FROM Services ORDER BY date DESC';
					   # itterates through every record returned by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['Service'] . '</td>';
							   	echo '<td>'. $row['Price'] . '</td>';
							   	echo '<td>'. $row['Date'] . '</td>';
							   	echo '<td width=250>';
							   	echo '<a class="btn" href="readservice.php?id='.
								   $row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="update.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="deleteservice.php?id='.$row['id'].'">Delete</a>';
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