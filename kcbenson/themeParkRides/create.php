<?php 
	# Consider three scenarios:
	# 1.User clicked create button on list screen (index.php)
	#		If that happens, then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry screen, but a field was empty
	#		If that happens, an error message shows next to the field
	# 3. User clicked create button (submit button) on entry screen, and all data was valid
	# 		If that happens, the PHP code inserts the record into the database and redirects to the list screen.
	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then insert the record, otherwise just display the HTML 
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$ageError = null;
		$emailError = null;
		$passwordError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$age = $_POST['age'];
		$interests = $_POST['interests'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter your name.';
			$valid = false;
		}
		
		if (empty($age)) {
			$ageError = 'Please select your age.';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter your email address.';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter a password.';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO parkCustomers (name, age, email, password) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name, $age, $email, $password));
			Database::disconnect();
			header("Location: index.php");
		}
	} #end if ( !empty($_POST))
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!-- The head section does the following: 
		1. Sets the character set
		2. includes Bootstrap
		-->
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Register New User</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($ageError)?'error':'';?>">
					    <label class="control-label">Age</label>
					    <div class="controls">
					      	<input name="age" type="text"  placeholder="Age" value="<?php echo !empty($age)?$age:'';?>">
					      	<?php if (!empty($ageError)): ?>
					      		<span class="help-inline"><?php echo $ageError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group">
					    <label class="control-label">Interests</label>
					    <div class="controls">
					      	<input type="checkbox" name="check_list[]" value="coaster"><label>Rollar Coasters</label><br/>
							<input type="checkbox" name="check_list[]" value="water"><label>Water Rides</label><br/>
							<input type="checkbox" name="check_list[]" value="children"><label>Children's Rides</label><br/>
							<input type="checkbox" name="check_list[]" value="family"><label>Family Rides</label><br/>
							<input type="checkbox" name="check_list[]" value="thrill"><label>Thrill Rides</label><br/>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <!--<div class="control-group">
					    <label class="control-label">Confirm Password</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Confirm Password" value="">
					    </div>
					  </div>-->
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="index.php">Back</a>
					  </div>
					

						
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>