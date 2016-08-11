<?php
/* ***************************************************************************************************************
 filename     : createcust.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file creates new customer, and adds them to the database when the user pushes the create button.
				
PURPOSE 	  : CRUD App : Create
INPUT		  : name, email, mobile, password
PRE     	  : The user must enter in all of the information in the fields
OUTPUT		  : A new customer is made
POST		  : Redirected back to the main page and a new customer has been added to the customer table
*****************************************************************************************************************/ 	 
*****************************************************************************************************************/ 	 
	session_start();
	$_SESSION['login_user']= $username;
	# Consider these scenarios.
	# 1. User clicked the create button on the list screen(index.php)
	#  If that happens then create.php displays a entry screen
	
	# 2. User clicked create button(sumbimt button) on entry screen, but a field was empty
	#	If that happens then an error messege appears next to the empy field(s)
	
	# 3. User clicks the create button and all data is valid
	#	IF that happens then the PHP code inserts the record and redirects to the list screen
	
	
	# include connection data and functions
	require 'elitedatabase.php';
	# If there was data passed then insert the record,
	# otherwise do nothing
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$descriptionError = null;
		$priceError = null;
		$dateError = null;
		
		// keep track post values
		$s_name = $_POST['s_name'];
		$description = $_POST['description'];
		$price = $_POST['price'];
		$date = $_POST['date'];
		
		// validate input
		$valid = true;
		if (empty($s_name)) {
			$s_nameError = 'Please enter Service Name';
			$valid = false;
		}
		
		if (empty($description)) {
			$descriptionError = 'Please enter a Description';
			$valid = false;
		} 
		
		if (empty($price)) {
			$priceError = 'Please enter a Price';
			$valid = false;
		}
		
		if (empty($date)) {
			$dateError = 'Please enter a Date';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO services (s_name,description,price,date) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($s_name,$description,$price,$date));
			Database::disconnect();
			header("Location: elite.php");
		}
	} # end if (!empty($_POST))
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Create a new Service</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="newservice.php" method="post">
					
					  <div class="control-group <?php echo !empty($s_nameError)?'error':'';?>">
					    <label class="control-label">Service Name</label>
					    <div class="controls">
					      	<input name="s_name" type="text"  placeholder="Service Name" value="<?php echo !empty($s_name)?$s_name:'';?>">
					      	<?php if (!empty($s_nameError)): ?>
					      		<span class="help-inline"><?php echo $s_nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="description" type="text" placeholder="Service Description" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($priceError)?'error':'';?>">
					    <label class="control-label">Price</label>
					    <div class="controls">
					      	<input name="price" type="text"  placeholder="Service Price" value="<?php echo !empty($price)?$price:'';?>">
					      	<?php if (!empty($priceError)): ?>
					      		<span class="help-inline"><?php echo $priceError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Date</label>
					    <div class="controls">
					      	<input name="date" type="text"  placeholder="Service Date" value="<?php echo !empty($date)?$date:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="elite.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>