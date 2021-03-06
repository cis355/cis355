<!--/* *******************************************************************
* filename : readRestaurant.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : displays the venue info from table on separate page.                
*               
*
* input : none
* processing : The program steps are as follows.
* 		1. when about me button is clicked it displays the venue info from table on separate page.
* 		
* 		
* 		
* output : displays the venue info from table on separate 
*
* precondition : none
* postcondition: displays the venue info from table on separate page.
* 				 
* *******************************************************************
*/-->

<?php
//keeps track of users session who are logged in
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

?>

<?php 
	//populates the about me section for customers to read
	require 'database.php'; //connects to database
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: restaurant.php");
	} else { //sql statement to pull info from database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM restaurant where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="restaurantStyle.css">
</head>
<style>
h3 {
	color:white;
}
label {
	color:white;
}
div {
	color:white;
}
</style>
<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>About Me</h3>
		    		</div>
		    		
	    			<div class="form-horizontal" >
					  <div class="control-group">
					    <label class="control-label">Name:</label>
						     	<?php echo $data['venueName'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Address:</label>
						     	<?php echo $data['address'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Venue Type:</label>
						     	<?php echo $data['type'];?>
					  </div>
					  <div class="control-group">
					    <label class="control-label">Venue Information:</label>
						     	<?php echo $data['info'];?>
					  </div>
					    <div class="form-actions">
						  <a class="btn btn-default" href="restaurant.php">Back</a>
					   </div>

					</div>
				</div>
				
    </div> <!-- /container -->
	<div id="background"><img class="stretch" src="blue.jpg"/></div>
  </body>
</html>