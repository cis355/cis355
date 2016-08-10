<?php 

  session_start();
  require 'database.php';

  #if there was data passed, then verify password,
  #otherwise do nothing (that is, just display html for login)
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$passwordError = null;
	
		
		// keep track post values
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($username)) {
			$usernameError = 'Please enter username';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter password';
			$valid = false;
		}
				
		// Verify that password is correct for the username
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($username));
			$result = $q->fetch(PDO::FETCH_ASSOC);
			if($result['password']==$password) {
				$_SESSION['username'] = $username;
				Database::disconnect();
				header("Location: index.php"); // redirect
		    }
			else $passwordError = 'Password is not valid.';
			Database::disconnect();
			
		}#end if valid
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
		    			<h3>Login</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="login.php" method="post">
					  <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					    <label class="control-label">Username</label>
					    <div class="controls">
					      	<input name="username" type="text"  placeholder="Username" value="<?php echo !empty($username)?$username:'';?>">
					      	<?php if (!empty($usernameError)): ?>
					      		<span class="help-inline"><?php echo $usernameError;?></span>
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
					  </br>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Login</button>
						  <a class="btn" href="create.php" class="btn btn-success">Create new account</a>
             <!-- <a class="btn" href="index.php">Back</a> -->
						</div>
            
         
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>
<?php   show_source(__FILE__); ?>