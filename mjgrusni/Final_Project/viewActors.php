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
    			<h3>View Actors</h3>
    		</div>
			<div class="row">
				<p>
					<a href="createActor.php" class="btn btn-success">Create Actor</a>
					<a href="createFilm.php" class="btn btn-success">Create Film</a>
					<a href="viewActors.php" class="btn btn-success">View Actors</a>
					<a href="index.php" class="btn btn-success">View All</a>
				</p>
				
				
				<table class="table table-striped table-bordered">
					
					   <?php 				   
					   # database.php contains connection code, including connect and disconnect functions
					   include 'database.php';
					   # connect to database and assign object to variable
					   $pdo = Database::connect();
					   # assign select statement to variable
					   $sql = 'SELECT * FROM films';
					   # iterates through every record return by the select statement
					   $selectString = '';
					   foreach ($pdo->query($sql) as $row) {
					   	$selectString = $selectString . '<option value="' . $row['film_name'] . '">' . $row['film_name'] . '</option>';
					   }
					   Database::disconnect();
					   //echo $selectString;
					   ?>
		              <thead>
		                <tr>
		                  <th>Name</th>
		                  <th>Movies</th>
		                </tr>
		              </thead>
		              <tbody>
					 
		              <?php 		
					
					   # connect to database and assign object to variable
					   $pdo = Database::connect();
					   # assign select statement to variable
					   $sql = 'SELECT * FROM actors';
					   # iterates through every record return by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td width=250>'. $row['actor_name'] . '</td>';
							   	echo '<td width=250>';
							   	echo '&nbsp;';
								echo '<form class="form-horizontal" action="addFilm.php" method="post"><select name="film">' . $selectString . '</select>';
								echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="addFilm.php?id='.$row['actor_id'].'">Add Film</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="deleteActor.php?id='.$row['actor_id'].'">Delete Actor</a>';
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