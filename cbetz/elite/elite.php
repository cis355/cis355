<?php
/* ************************************************************************************ 
 filename     : prg3.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file contains the class that returns the JSON object
				of the query and displays them in a table.
				
PURPOSE 	  : CRUD application for Lawn Care services. Creates customers,
				creates services, creates contracts, updates services, deletes services
INPUT		  : NONE
PRE     	  : All of the tables must be working and filled out.
OUTPUT		  : Prining out the table based on the customer logged in.
POST		  : Front end displays all of the correct information
***************************************************************************************/ 
session_start();
// Store Session Data
if (empty($_SESSION['name'])) header("Location: loginelite.php"); //redirect
$name = $_SESSION['name'];
?>

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

<body <!--style="background-image: url('http://www.publicdomainpictures.net/pictures/40000/velka/grass-1366796906dab.jpg')-->;">
	<!-- The head section does the follwing.
		1. Displays Heading
		2. Displays Create button
		3. Displays rows of database records
		4. Displays Toturial button
		-->
    <div class="container">
    		<div class="row">
    			<a href="http://www.auplod.com/i-poldau82986.html"><img src="http://www.auplod.com/u/poldau82986.png" alt="Image" border="0" /></a>
				
    		</div>
			<div class="row">	
			<p>
				<p>
				   <a href="logoutelite.php" class="btn btn-danger">Logout <?php echo $name ?> </a>
				</p>
			</p>
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Service</th>
						  <th>Description</th>
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
					   #$sql = 'SELECT * FROM `services`';
					   $sql = 'SELECT * FROM `contracts` INNER JOIN `services` INNER JOIN `customers` WHERE services.id = contracts.serviceID AND customers.id = contracts.customerID';
					   # itterates through every record returned by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['s_name'] . '</td>';
							   	echo '<td>'. $row['description'] . '</td>';
							   	echo '<td>'. $row['price'] . '</td>';
								echo '<td>'. $row['date'] . '</td>';
							   	echo '<td width=250>';
								echo '<a class="btn" href="readservice.php?id='. $row['serviceID'].'">Read</a>';
								echo '<a class="btn btn-success" href="updateservice.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" href="deleteservice.php?id='.$row['id'].'">Delete</a>';
							   	echo '&nbsp;';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
				<p>
					<a href="newservice.php" class="btn btn-success">New Service</a>
					<a href="newcontract.php" class="btn btn-success">New Contract</a>
				</p>
    	</div>
    </div> <!-- /container -->
  </body>
</html>
<?php
//show_source(__FILE__); 
?>