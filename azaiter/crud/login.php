<?php 
	session_start();
	# include database class required to make DB connection
	require 'database.php';
	
	# checks if post request has been made, if post request is made handle the create operation
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$passwordError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$password = $_POST['password'];
		$redirect = $_POST['redirect'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($password)) {
			$emailError = 'Please enter password';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "Select * from customers where name = ? limit 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			//print_r($results);
			if($results['password']==$password){
				echo "logged in";
				$_SESSION["user_id"] = $results['id'];
				$_SESSION["username"] = $name;
				$_SESSION["password"] = $password;
				header("Location: main.php");
			} else {
				echo "<font color='red'><b>Username Or Password incorrect!</b></font>";
			}
			echo $redirect;
			Database::disconnect();
			
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
		    			<h3>Login</h3>
						<p><?php echo $_SESSION['url_referer']; ?></p>
		    		</div>
    		
	    			<form class="form-horizontal" action="login.php" method="post">
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
					      	<input name="password" type="password" placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Login</button>
						  <a class="btn" href="main.php">Back</a>
						</div>

					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>