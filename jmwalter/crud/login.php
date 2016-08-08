<?php 
	// uses information in the database.php to link to the db
	session_start();
	require 'database.php';
	if ( !empty($_POST)) {
		// keep track validation errors
		// if data was passsed insert record .. else do nothing 
		$nameError = null;
		$passwdError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$passwd = $_POST['passwd'];
		
		// validate input
		// checks that you filled all the fields. 
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($passwd)) {
			$passwdError = 'Please enter Password';
			$valid = false;
		}
		
		// verify password is correct for user name
		// uses data in the form below to insert a row into the db table 
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM customers WHERE name = ?LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			if ($results['password'] == $passwd)
			{
				$_SESSION['name'] = $name;
				header("Location: index.php");
				//echo "<p>success</p>";
			}
			else 
				$passwdError = 'Password not valid for User name';
			
			
			//print_r($results);
		
			Database::disconnect();
			//header("Location: index.php");
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
		    		</div>
    		
	    			<form class="form-horizontal" action="login.php" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">UserName</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="User Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwdError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="passwd" type="password" placeholder="Email Address" value="<?php echo !empty($passwd)?$passwd:'';?>">
					      	<?php if (!empty($passwdError)): ?>
					      		<span class="help-inline"><?php echo $passwdError;?></span>
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