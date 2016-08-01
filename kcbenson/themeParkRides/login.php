<?php 
	
	session_start();
	
	# Consider two scenarios:
	# 1.User clicked create button on list screen (index.php)
	#		If that happens, then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry screen, but a field was empty
	#		If that happens, an error message shows next to the field
	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then verify the password, otherwise just display the HTML for login
	if ( !empty($_POST)) {
		// keep track validation errors
		$emailError = null;
		$passwordError = null;
		
		// keep track post values
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($email)) {
			$emailError = 'Please enter your email.';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter your password.';
			$valid = false;
		}
		
		// verify password is correct for username
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM parkCustomers WHERE email = ? LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($email));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			if($results['password']==$password) {
				$_SESSION['email'] = $email;
				Database::disconnect();
				header("Location: home.php"); //redirect
			}
			else {
				$passwordError = 'Invalid password.';
				Database::disconnect();
			}
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
		    			<h3>Login</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="login.php" method="post">
					
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email</label>
					    <div class="controls">
					      	<input name="email" type="text"  placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password" placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Login</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
						
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>