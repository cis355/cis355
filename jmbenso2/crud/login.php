<?php 

	session_start(); // Start a session, if it hasn't been yet
	
	require 'database.php';
	if ( !empty($_POST)) { // If anything's been posted
		// keep track validation errors
		$nameError = null;
		$passwordError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($name)) { // If no name was read/posted
			$nameError = 'Please enter Username'; // Show error message
			$valid = false; // If this is set to false anywhere, prevents us from inserting data later on
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter Password'; // If no email was read/posted
			$valid = false;
		}
		
		// verify that password is correct for username
		if ($valid) {
			$pdo = Database::connect(); // Connect to database, reference in $pdo variable
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set attributes of connection
			$sql = "SELECT password FROM customers WHERE name=? LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			if ($results['password'] == $password) {
				// Set session variable 
				$_SESSION['name'] = $name;
				Database::disconnect();
				header("Location: index.php"); // Redirect to index, if successful.
			} else {
				$passwordError = 'Incorrect username or password.'; // Error, and no redirect
				Database::disconnect();
			}
			
			
			
		}
	}
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
		    			<h3>Log In</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="login.php" method="post">
					
						
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>"><!--If we have a value for error, print it here -->
					    <label class="control-label">Username</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>"> <!-- If we have a value for name, print it here -->
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
						  <button type="submit" class="btn btn-success">Login</button>
						  <a class="btn" href="index.php">Back</a>
						</div>
						
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>