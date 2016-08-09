<?php 

	# Consider three scenarios
	# 1. User clicked "create" button on list screen (index.php)
	#		-create.php displays blank entry screen
	# 2. User clicked "create" button (submit button) on entry screen, but a field was empty
	#		-Displays an error message next to the empty field
	# 3. User clicked "create" button (submit button) on entry screen and all data valid
	# 		-PHP code inserts the record and redirects to the list screen
	
	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
	if ( !empty($_POST)) {
		// keep track validation errors
		$firstnameError = null;
		$lastnameError = null;
		$usernameError = null;
		$passwordError = null;
		$emailError = null;

		
		// keep track post values
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		
		
		// validate input
		$valid = true;
		if (empty($firstname)) {
			$firstnameError = 'Please enter first name';
			$valid = false;
		}
    
		if (empty($lastname)) {
			$lastnameError = 'Please enter last name';
			$valid = false;
		}
    
		if (empty($username)) {
			$usernameError = 'Please enter username';
			$valid = false;
		}
    
    if (empty($password)) {
			$passwordError = 'Please enter password';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
    
 
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO users (firstname,lastname,username,password,email) values(?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($firstname,$lastname,$username,$password,$email));
			Database::disconnect();
			header("Location: index.php");
		}
	} # end if(!empty($_POST))
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
		    			<h3>Create an account</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					  <div class="control-group <?php echo !empty($firstnameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input name="firstname" type="text"  placeholder="John" value="<?php echo !empty($firstname)?$firstname:'';?>">
					      	<?php if (!empty($firstnameError)): ?>
					      		<span class="help-inline"><?php echo $firstnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
            
             <div class="control-group <?php echo !empty($lastnameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="lastname" type="text"  placeholder="Doe" value="<?php echo !empty($lastname)?$lastname:'';?>">
					      	<?php if (!empty($lastnameError)): ?>
					      		<span class="help-inline"><?php echo $lastnameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
            
             <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					    <label class="control-label">Username</label>
					    <div class="controls">
					      	<input name="username" type="text"  placeholder="johndoe10" value="<?php echo !empty($username)?$username:'';?>">
					      	<?php if (!empty($usernameError)): ?>
					      		<span class="help-inline"><?php echo $usernameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
            
             <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password"  placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
            
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="johndoe@john.doe" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
            
            </br>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>