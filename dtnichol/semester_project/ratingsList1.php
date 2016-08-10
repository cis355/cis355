<!--/* *******************************************************************
* filename : ratingsList1.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : displays the ratings and reviews table on the website.                
*               
*
* input : none
* processing : The program steps are as follows.
* 		1. automatically displays any ratings and reviews from the database onto the website
* 		
* 		
* 		
* output : displays ratings1 table
*
* precondition : none
* postcondition: displays ratings1 table
* 				 
* *******************************************************************
*/-->

<?php
//keeps track of users session who are logged in
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

?>



<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
	1. Sets the character set 
	2. includes bootstrap-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- The body section does the following.
	1. Displays heading
	2. Displays a "create" button
	3. Displays rows of a database record (from MySql database)
	4. Displays "tutorial Button"-->
    <div class="container">
    		<div class="row">
    			<h3>Ratings of Products by Customers</h3>
    		</div>
			<div class="row">
				
				
				<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
		                  
		                  <th>Restaurant</th>
		                  <th>Customer</th>
		                  <th>Rating</th>
						  <th>Review</th>
		                </tr>
		              </thead>
		              <tbody>
		              <?php 
					  //database.php contains connection code, including connect and disconnect functions
					   include 'database.php';
					   //connect to database and assign object to variable
					   $pdo = Database::connect();
					   
					   //assign select statement to variable
					   $sql = 'SELECT * FROM `ratings1` INNER JOIN `restaurant` INNER JOIN `customers1` WHERE restaurant.id = ratings1.restaurantID AND customers1.id = ratings1.customers1ID';
					   //iterates through every record return by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
						   		echo '<tr>';
							   	//echo '<td>'. $row[0] . '</td>';
							   	echo '<td>'. $row['venueName'] . '</td>';
							   	echo '<td>'. $row['name'] . '</td>';							   							
							   	echo '<td>'. $row['rating'] . '</td>';
								echo '<td>'. $row['review'] . '</td>';
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