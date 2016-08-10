<!-- 
filename  : http://csis.svsu.edu/~ecfeders/cis355/ecfeders/Homework/homework2.php.html
author    : Erik Federspiel
date      : 2016-08-1
email     : ecfeders@svsu.edu
course    : CIS-355
link      : http://csis.svsu.edu/~ecfeders/cis255/ecfeders/Program2/program2.html
backup    : https://github.com/cis255/cis255
purpose   : This file serves as a program02 Assignment for the course, 
			CIS-255: Client Side Web Development, 
			at Saginaw Valley State University (SVSU)
copyright : GNU General Public License (http://www.gnu.org/licenses/)
			This program is free software: you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation, either version 3 of the License, or
			(at your option) any later version.
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.   
external code used in this file: 

external code references in this file: 
		
program structure (design):
	Class{
		Displpay 
		Show html
	}
	
	create instantiation 
	call display


 -->
<?php
	class registrations {
		//Member Data
		private static $id;
		private static $class;
		private static $startTime;
		private static $endTime;
		private static $day;
		
		
		public function displayRecords () { 
?>	
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
						<h3>Registrations</h3>
					</div>
					<div class="row">
						<p>
							<a href="create.php"  class="btn btn-success">Create</a>
						</p>
						
						<!-- Table Titles !-->
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
								<th>Class</th>
								<th>Start Time</th>
								<th>End Time</th>
								<th>Day(s)</th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
						    <?php
							  // MYSQLI Connect Variables
								$servername = "localhost";
								$username = "ecfeders";
								$password = "Nurseal5";
								$dbname = "ecfeders";
								
								// Create connection
								$conn = new mysqli($servername, $username, $password, $dbname);
								// Check connection
								if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								} 
								//SQl Statment
								$sql = "SELECT * FROM registrations ORDER BY class";
								$result = $conn->query($sql);
								
								if ($result->num_rows > 0) {
									
									// output data of each row
									while($row = $result->fetch_assoc()) {
										echo '<tr>';
										echo '<td>'. $row['class'] . '</td>';
										echo '<td>'. $row['startTime'] . '</td>';
										echo '<td>'. $row['endTime'] . '</td>';
										echo '<td>'. $row['day'] . '</td>';
										echo '<td width="250">';;
										echo '<a class="btn btn-success" href="read.php?id='.$row['id'].'">Read</a>';
										echo '&nbsp;';
										echo '<a class="btn btn-success" href="update.php?id='.$row['id'].'">Update</a>';										
										echo '&nbsp;';
										echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
										echo '</td>';
										echo '</tr>';
									}
								} else {
									echo "0 results";
								}
								//Close connection
								$conn->close();
							?>
							</tbody>
						</table>
				</div>
			</div> <!-- /container -->
		</body>
		</html>
		
<?php		
		}
		
		
} 

    //Create instantiation and call fucntion
	$cust1 = new registrations;
	$cust1->displayRecords();
	
	show_source (__FILE__);

?>