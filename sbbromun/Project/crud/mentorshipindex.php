<?php
/* *******************************************************************
* filename : mentorshipindex.php
* author : Samuel Bromund
* username : sbbromun
* course : cis355
* section : 11-MW
* semester : Summer 2016
*
* description : This file displays all mentorships
* by reading them from a database table(Mentorships),
* shows options for manipulating records with CRUD.
* It also displays a navbar at the top of the page.

* input : user input
*
* precondition : database with tables: Players, Mentors, Mentorships
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
				<li><a href="playerindex.php">Players</a></li>
				<li><a href="mentorindex.php">Mentors</a></li> 
				<li><a href="mentorshipindex.php">Mentorships</a></li> 
				</ul>
			</div>
			</nav>
			<!--Header-->
    		<div class="row">
    			<h3>Current Mentorship List</h3>
    		</div>
			<div class="row">
			<!--Create Button-->
				<p>
					<a href="mentorshipcreate.php" class="btn btn-success">Create</a>
				</p>
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  <th>Learner Name</th>
		                  <th>Mentor Name</th>
		                  <th>Role to Train</th>
		                  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					   #database.php includes connection code, including connect and disconnect functions
					   include 'database.php';
					   # connect to database and assign object to variable
					   $pdo = Database::connect();
					   # Assign SQL SELECT Statement to a variable. Uses inner join to get other tables info. This is associative.
					   $sql = 'SELECT * FROM Mentorships INNER JOIN Teachers INNER JOIN Players WHERE Teachers.mentorID = Mentorships.teacherID AND Players.learnerID = Mentorships.playerID';
					   #Prints the table for each record found. Also prints buttons for CRUD processing
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	echo '<td>'. $row['playerSummonerName'] . '</td>';
							   	echo '<td>'. $row['teacherSummonerName'] . '</td>';
							   	echo '<td>'. $row['roleToTrain'] . '</td>';
							   	echo '<td width="250">';
							   	echo '<a class="btn btn-primary" href="mentorshipread.php?id='.
								   $row['id'].'">Read</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-success" 
								   href="mentorshipupdate.php?id='.$row['id'].'">Update</a>';
							   	echo '&nbsp;';
							   	echo '<a class="btn btn-danger" 
								   href="mentorshipdelete.php?id='.$row['id'].'">Delete</a>';
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