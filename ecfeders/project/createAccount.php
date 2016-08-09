<?php 
	# Consider Three Scenrarios
	# 1. The user clicked the create button on list screen (index.php)
	# 		if That happens then create.php displays entry screen
	# 2. User clicked the create/submit button on the entry screen, but a field was empty
	# 		If that happens an error message will appear next to empty filds
	# 3. User clicks submit and all the data is valid
	# 		The php code inserts the record and redirects to the list screen (index.html)
	# include connection data and functions
	require 'databaseProject.php';
	# if there was data passed, then insert the record, otherwise wait
	# otherwise just display the html
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$bussIDError = null;
		$positionError = null;
		$passwordError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$buss_id = $_POST['buss_id'];
		$position = $_POST['position'];
		$password = $_POST['password'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter a Name';
			$valid = false;
		}
		
		if (empty($buss_id)) {
			$bussIDError = 'Please enter Business ID';
			$valid = false;
		}
		
		if (empty($position)) {
			$positionError = 'Please enter your Position';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter a Password';
			$valid = false;
		}
		
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO workers (name,buss_id,position,password) values(?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$buss_id,$position,$password));
			Database::disconnect();
			header("Location: loginProject.php");
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
		    			<h3>Create an Account</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="createAccount.php" method="post">
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($bussIDError)?'error':'';?>">
					    <label class="control-label">Business ID</label>
					    <div class="controls">
					      	<input name="buss_id" type="text" placeholder="Business ID" value="<?php echo !empty($buss_id)?$buss_id:'';?>">
					      	<?php if (!empty($bussIDError)): ?>
					      		<span class="help-inline"><?php echo $bussIDError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($positionError)?'error':'';?>">
					    <label class="control-label">Position</label>
					    <div class="controls">
					      	<input name="position" type="text"  placeholder="Position" value="<?php echo !empty($position)?$position:'';?>">
					      	<?php if (!empty($positionError)): ?>
					      		<span class="help-inline"><?php echo $positionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="text"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Sign Up</button>
						  <a class="btn" href="loginProject.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>