 <!--/* *******************************************************************
* filename : createRestaurant.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : displays the create restaurant form and when submitted it inserts it into the restaurants *				 database.                
*               
*
* input : admin enters information into the add new venue form and is inserted into restaurant table
* processing : The program steps are as follows.
* 		1. admin enters new venue information
* 		2. submit form
* 		3. information is inserted into database table
* 		
* output : new venue will be displayed on screen
*
* precondition : admin must be logged in to add new venue when button is clicked
* postcondition: information added in database
* 				 
* *******************************************************************
*/-->





<?php 
	//for admin to create new venue
	//keeps track of users session who are logged in
	session_start();
	if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

	//consider three scenarios. 
	//1. user clicked the create buttong on the list screen (index.php)
	//		if that happens then create.php displays blank entry screen
	//2. User clicked the create button (submit button) on the entry screen but one or more fields were empty
	//		If that happens then error message appears nexxt to empty field(s)
	//3. User clicked create button (submit button) and all data valid
	//		If that happens then the PHP code inserts the record and redirects to the list screen (index.php)
	
	// include connection data and functions
	require 'database.php';
	
	//if there was data passed, then insert the record, otherwise do nothing (that is, just display html)
	if ( !empty($_POST)) {
		// keep track validation errors
		$venueNameError = null;
		$addressError = null;
		$mapError = null;
		$typeError = null;
		$infoError = null;
		
		// keep track post values
		$venueName = $_POST['venueName'];
		$address = $_POST['address'];
		$map = $_POST['map'];
		$type = $_POST['type'];
		$info = $_POST['info'];
		
		// validate input
		$valid = true;
		if (empty($venueName)) {
			$venueNameError = 'Please enter Venue Name';
			$valid = false;
		}
		
		if (empty($address)) {
			$addressError = 'Please enter Address';
			$valid = false;
		} 
		
		
		if (empty($map)) {
			$mapError = 'Please enter Map URL';
			$valid = false;
		}
		
		if (empty($type)) {
			$typeError = 'Please enter Venue Type';
			$valid = false;
		}
		
		if (empty($info)) {
			$infoError = 'Please enter Dining Information';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO restaurant (info,venueName,address,map,type) values(?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($info, $venueName, $address, $map, $type));
			Database::disconnect();
			header("Location: restaurant.php");
		}
	} // end if (!empty($_POST))
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
</style>
<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Add a New Venue</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="createRestaurant.php" method="post">
					
					  <div class="control-group <?php echo !empty($venueNameError)?'error':'';?>">
					    <label class="control-label">Venue Name</label>
					    <div class="controls">
					      	<input name="venueName" type="text"  placeholder="Venue Name" value="<?php echo !empty($venueName)?$venueName:'';?>">
					      	<?php if (!empty($venueNameError)): ?>
					      		<span class="help-inline"><?php echo $venueNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($addressError)?'error':'';?>">
					    <label class="control-label">Address</label>
					    <div class="controls">
					      	<input name="address" type="text" placeholder="Address" value="<?php echo !empty($address)?$address:'';?>">
					      	<?php if (!empty($addressError)): ?>
					      		<span class="help-inline"><?php echo $addressError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($mapError)?'error':'';?>">
					    <label class="control-label">Map URL</label>
					    <div class="controls">
					      	<input name="map" type="text"  placeholder="Map URL" value="<?php echo !empty($map)?$map:'';?>">
					      	<?php if (!empty($mapError)): ?>
					      		<span class="help-inline"><?php echo $mapError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($typeError)?'error':'';?>">
					    <label class="control-label">Venue Type</label>
					    <div class="controls">
					      	<input name="type" type="text"  placeholder="Venue Type" value="<?php echo !empty($type)?$type:'';?>">
					      	<?php if (!empty($typeError)): ?>
					      		<span class="help-inline"><?php echo $typeError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($infoError)?'error':'';?>">
					    <label class="control-label">Venue Information</label>
					    <div class="controls">
					      	<textarea name="info" type="textarea"  placeholder="Venue Info" rows="4" cols="25" value="<?php echo !empty($info)?$info:'';?>"></textarea>
					      	<?php if (!empty($infoError)): ?>
					      		<span class="help-inline"><?php echo $infoError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="restaurant.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
	<div id="background"><img class="stretch" src="blue.jpg"/></div>
  </body>
</html>