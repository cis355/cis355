<!--/* *******************************************************************
* filename : restaurant.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : This program allows you to create, read, update, and delete from the restaurant  
				database we created in PHPMyAdmin.
				Class Restaurant contains the functions to display records and display ratings which will also generate the html forms for
				the table style look for the restaurants and ratings in the database. 
				Inside the tables if the admin is logged in there are buttons to update the restaurants and then delete buttons in the ratings table. If someone else is logged in that is not an admin then they only see the customers list and the about me and rate and review buttons.
				There is also the functions for the create button and delete button that links to the createRestaurant.php and deleteRestaurant.php file.
				
				Then outside of the class is the php that calls the functions in the class Customer
*input : createRestaurant and updateRestaurant are the input functions of this program
processing : The program steps are as follows.
*		1. creates class restaurant
* 		2. instantiates a new class
* 		3. update, read, or delete are linked with separate php files
* 		
* output : displayRecords prints the venue table and the rating/reviews table onto the website 
*
* precondition : must instantiate a new class to begin
* postcondition: information printed to the screen,
* *******************************************************************
*/-->

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following.
	1. Sets the character set 
	2. includes bootstrap-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="restaurantStyle.css">
</head>
<style>

</style>
<body>
	<div id="background"><img class="stretch" src="cityscape.jpg"/></div>
	<p>
		<a href="logout1.php" class="btn btn-danger">Logout</a>
	</p>	
	<p>
		<a href="index1.php" class="btn btn-success">Customers List</a>
	</p>
	
<?php
//keeps track of a users login session
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

?>
<?php
require ("database.php");


class Restaurant {
	private static $id;

	
	
	
	//function to display the restaurant records
	public function displayRecords () {
		$pdo = Database::connect();
		$sql = 'SELECT * FROM restaurant WHERE 1';
		
		echo '<table class="table table-striped table-bordered">
		              <thead>
		                <tr>
						  <!--th>image</th-->
		                  <th>Name</th>
		                  <th>Address</th>
						  <th>Location</th>
						  <th>Type</th>
						  <th>Action</th>
		                </tr>
		              </thead>
		              <tbody>';
			
			
		
		//iterates through every record return by the select statement
		   foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						//echo '<td>';
						//echo "<img src='Image/" . $row['imageLink']"'/>";
						echo '<td>'. $row['venueName'] . '</td>';
						echo '<td>'. $row['address'] . '</td>';
						echo '<td>';
						echo '<a href='. $row['map'] . '>Map</a>';
						echo '<td>'. $row['type'] . '</td>';
						
						echo '<td width=450>';
						echo '<a class="btn btn-primary" href="readRestaurant.php?id='.
						$row['id'].'">About Me</a>';
						echo '&nbsp;';
						if ($_SESSION['id'] == 1){//gives admin priviledges to id one
						echo '<a class="btn btn-success" 
						href="updateRestaurant.php?id='.$row['id'].'">Update</a>';
						echo '&nbsp;';
						
						echo '<a class="btn btn-danger" 
						href="deleteRestaurant.php?id='.$row['id'].'">Delete</a>';
						}
						echo '&nbsp;';
						echo '<a class="btn btn-default" href="createRating.php?id='.$row['id'].'">Rate and Review Me</a>';
						echo '</td>';
						echo '</tr>';
		}
		Database::disconnect();
	} //end function display records
	
	public function displayRatings (){
		$pdo = Database::connect();
		 $sql = 'SELECT * FROM `ratings1` INNER JOIN `restaurant` INNER JOIN `customers1` WHERE restaurant.id = ratings1.restaurantID AND customers1.id = ratings1.customers1ID';
		 
		 //outputs the html table headers
					   echo '</tbody></table>';
					   echo '<h1 align="center">Ratings and Reviews</h1>';
						echo '<table class="table table-striped table-bordered">';
		                echo '<thead>';
		                echo '<tr>';
		                  echo '<th>Entertainment Venue</th>';
		                  echo '<th>Customer</th>';
						  echo '<th>Rating</th>';
						  echo '<th>Review</th>';
						  if ($_SESSION['id'] == 1){
								echo '<th>Action</th>';
								}
		               echo '</tr>';
		              echo '</thead>';
		              echo '<tbody>';




					  
					   //iterates through every record return by the select statement
	 				   foreach ($pdo->query($sql) as $row) {
								
						   		echo '<tr>';
							   	//echo '<td>'. $row['id'] . '</td>';
							   	echo '<td>'. $row['venueName'] . '</td>';
							   	echo '<td>'. $row['name'] . '</td>';							   							
							   	echo '<td>'. $row['rating'] . '</td>';
								echo '<td>'. $row['review'] . '</td>';
								if ($_SESSION['id'] == 1){ //gives admin priviledges to id one
									echo '<td>';
									
									echo '<a class="btn btn-danger" 
									href="deleteRating.php?id='.$row[0].'">Delete</a>';
								}
							   	echo '</tr>';
					   }
						Database::disconnect();
	
	}//end function display ratings
					   
					   
					   
		
	
	
	
	//displays the add new venue button
	function displayCreateButton(){
		if ($_SESSION['id'] == 1)
		echo "<a href='createRestaurant.php?create=yes' class='btn btn-success'>Add New Venue</a><br />";
		
	}
	//displays the delete venue button
	function deleteButton(){
		if ($_SESSION['id'] == 1)
		echo "<a href='createRestaurant.php?create=yes' class='btn btn-success'>Delete Venue</a><br />";
		
	}
	
	
}
//instantiates the class restaurant
$rest1 = new Restaurant;

//calls the functions in the class
$rest1->displayCreateButton();
echo "<h1 align='center'>Entertainment Venues</h1><br />";

$rest1->displayRecords();
$rest1->displayRatings();


echo "<br />";
//print_r($_SESSION);



?>

</body>
</html>