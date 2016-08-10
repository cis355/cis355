<?php
	session_start();
	if(empty($_SESSION['name'])){
		header("Location: loginProject.php"); // redirect 
    }
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
    			<h3>Food Safety</h3>
    		</div>
			<div class="row">
				<p>
					<a href="createSheet.php" class="btn btn-success">Create</a>
					<a href="logoutProject.php" class="btn btn-danger">Log Out</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                    <th>Business</th>
							<th>Worker</th>
							<th>Date</th>
							<th>Action</th>
		              </thead>
		              <tbody>
		              <?php 
					    $employeeBussinessID = $_SESSION['buss-id'];
					   # databse.php contains connection code including connect and disconnect
					   # functions
					   include 'databaseProject.php';
					   # connecting to the database and assign object to variable
					   $pdo = Database::connect();
					   # assigning variable for the SELECT STATEMENT
					   $sql = 'SELECT businesses.name AS busName, workers.name As workerName, 
					     sheet.dateMod As date, sheet.id As ID, workers.buss_id As bus_id FROM sheet INNER JOIN workers ON workers.id = sheet.worker_id
								INNER JOIN businesses ON businesses.id = sheet.buss_id';
					   # iterates through every record return by the select statment above
	 				   foreach ($pdo->query($sql) as $row) {
						   if($employeeBussinessID == $row['bus_id']){
						   		echo '<tr>';
							   	echo '<td>'. $row['busName'] . '</td>';
							   	echo '<td>'. $row['workerName'] . '</td>';
							   	echo '<td>'. $row['date'] . '</td>';
							   	echo '<td width="250">';
							   	echo '<a class="btn" href="readProject.php?id='.
								   $row['ID'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="updateProject.php?id='.$row['ID'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="deleteProject.php?id='.$row['ID'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
						   }
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
    	</div>
    </div> <!-- /container -->
  </body>
</html>