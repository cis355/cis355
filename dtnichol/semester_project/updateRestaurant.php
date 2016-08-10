 <!--/* *******************************************************************
* filename : updateRestaurant.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : displays the venue that is chosen to be updated and then sends updates to database when
*               submitted.
*
* input : no input for this file
* processing : The program steps are as follows.
* 		1. displays database table to be changed
* 		2. changes database if changes were made
* 		
* 		
* output : none
*
* precondition : none
* postcondition: information changed in database
* 				 
* *******************************************************************
*/-->
 
 <?php
 //keeps track of users session who are logged in
session_start();
if (empty($_SESSION['id'])) header("Location: login1.php"); //redirect

?>
 
 <?php 
	
	require 'database.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: restaurant.php");
	}
	
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
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE restaurant  SET info = '$info', venueName = '$venueName', address = '$address', map = '$map', type = '$type' WHERE id = $id";
			//print_r($sql);
			$q = $pdo->prepare($sql);
			$q->execute(array($info,$venueName,$address,$map,$type));
			Database::disconnect();
			header("Location: restaurant.php");
		}
	} else { //populates the text input fields
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM restaurant where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$venueName = $data['venueName'];
		$address = $data['address'];
		$map = $data['map'];
		$type = $data['type'];
		$info = $data['info'];
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
.wideInput{
	  text-align: left;
 padding-top: 0;
   padding-left: 0;
   line-height: 1em;
width: 200px;
    height: 200px;
}
</style>
<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update a Venue</h3>
		    		</div>
    		
	    			<form class="form-horizontal"  action="updateRestaurant.php?id=<?php echo $id?>" method="post">
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
					      	<input class="wideInput" name="info" type="text"  placeholder="Venue Info"  value="<?php echo !empty($info)?$info:'';?>">
					      	<?php if (!empty($infoError)): ?>
					      		<span class="help-inline"><?php echo $infoError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Update</button>
						  <a class="btn btn-default" href="restaurant.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
<div id="background"><img class="stretch" src="blue.jpg"/></div>
  </body>
</html>