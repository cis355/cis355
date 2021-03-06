<?php 
/* ***************************************************************************************************************
 filename     : loginelite.php   
 author       : Chad Betz   
 course       : cis355     
 semester     : Summer 2016   
 description  : This file gets the username of the user logging in, and logs in a user
				
PURPOSE 	  : This starts a session and lets the user log in to the website		
INPUT		  : name,password
PRE     	  : There must be users that can log into the system
OUTPUT		  : sussesfull login
POST		  : Redirected to the main page and logged in as the user
*****************************************************************************************************************/	
	session_start();
	$_SESSION['login_user']= $username;
	
	
	# include connection data and functions
	require 'elitedatabase.php';
	
	# if there was data passed, then verify password, 
	# otherwise do nothing (that is, just display html for login)
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$passwordError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter user name';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter password';
			$valid = false;
		} 
		
		// verify that password is correct for user name
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM customers WHERE name = ? LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			if($results['password']==$password) {
				$_SESSION['name'] = $name;
				Database::disconnect();
				header("Location: elite.php"); // redirect
			}
			else {
				$passwordError = 'Password is not valid';
				Database::disconnect();
			}
		}
	} # end if ( !empty($_POST))
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
		    			<h3>Login</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="loginelite.php" method="post">
					
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="User Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password" placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-primary">Login</button>
						</div>
						
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>