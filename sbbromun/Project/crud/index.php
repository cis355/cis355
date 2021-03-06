<?php
/* *******************************************************************
* filename : index.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file displays all Learners
* by reading them from a database table(Players),
* shows options for manipulating records with CRUD.
* It also displays a navbar at the top of the page.

* input : user input
*
* precondition : database with tables: Players
* postcondition: records and buttons printed to the screen,
* *******************************************************************
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
			1. Defines character
			2. Includes bootstrap -->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- The head section does the following.
			1. Display Navbar
			2. Displays heading
			3. Displays create button
			4. Displays rows of database records (from MySQL database)
			5. Displays tutorial button. -->
    <div class="container">
			<!--Navbar-->
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
				<a class="navbar-brand" href="#">League of Learners</a>
				</div>
				<ul class="nav navbar-nav">
				<li><a href="index.php">Learners</a></li>
				<li><a href="mentorindex.php">Mentors</a></li> 
				<li><a href="mentorshipindex.php">Mentorships</a></li> 
				</ul>
			</div>
			</nav>
			<!--Header-->
    		<div class="row">
    			<h3>Learner List</h3>
    		</div>
			<div class="row">
			<!--Create Button-->
				<p>
					<a href="playercreate.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Summoner Name</th>
		                  <th>Player Rank</th>
		                  <th>Roles to Learn</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   #database.php includes connection code, including connect and disconnect functions
					   include 'database.php';
					   # connect to database and assign object to variable
					   $pdo = Database::connect();
					   # Assign SQL SELECT Statement to a variable
					   $sql = 'SELECT * FROM Players ORDER BY learnerID DESC';
					   #Prints the table for each record found. Also prints buttons for CRUD processing
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['playerSummonerName'] . '</td>';
							   	echo '<td>'. $row['playerRank'] . '</td>';
							   	echo '<td>'. $row['rolesToLearn'] . '</td>';
							   	echo '<td width="250">';
							   	echo '<a class="btn btn-primary" href="playerread.php?learnerID='.
								   $row['learnerID'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="playerupdate.php?learnerID='.$row['learnerID'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="playerdelete.php?learnerID='.$row['learnerID'].'">Delete</a>';
							   	echo '</td>';
							   	echo '</tr>';
					   }
					   Database::disconnect();
					  ?>
				      </tbody>
	            </table>
				<!-- This is the source for the base code for this project!-->
				<a href="http://www.startutorial.com/articles/view/php-crud-tutorial-part-1" class="btn btn-success">Tutorial</a>
    	</div>
    </div> <!-- /container -->
  </body>
</html>