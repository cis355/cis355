<?php 

	
	session_start();
	// include connection data and functions
	require 'database.php';
	
	//if there was data passed, then verify the password, otherwise do nothing (that is, just display html)
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
			$nameError = 'Please enter Username';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter Password';
			$valid = false;
		
		}
		
		
		
		// verify that password is correct for the username
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM customers1 WHERE name = ? limit 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			if($results['password']==$password){
				$_SESSION['id'] = $results['id'];
				Database::disconnect();//redirect
				header("Location: restaurant.php");
			}
			else {
				$passwordError = 'Password is not valid';
			Database::disconnect();
			
			}
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
a {
	color: white;
}
form {
	float-right: 500px;
}
</style>

<body>
	
    <div class="container" align="center">
			
    			<div class="col-xs-4" align="center">
    				<div class="row" align="center">
		    			<h3>Login</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="login1.php" method="post" >
					
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Username</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
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
						  <a class="btn" href="index1.php">Back</a>
						  <br />
						  <a class="btn" href="register.php">Register for FREE!</a>
						</div>
						
						
					</form>
					
				</div>
			
			
					
				
		
    </div> <!-- /container -->
	<div id="background"><img class="stretch" src="blue.jpg"/></div>
  </body>
</html>