<?php 

	# Consider three scenarios.
	# 1. User clicked create button on list screen (index.php)
	#         If that happens then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry screen but one or more fields were empty
	#         If that happens then error message(s) appears next to empty field(s)
	# 3. User clicked create button (submit button) and all data valid
	#         If that happens then PHP code inserts the record and redirect to list screen (index.php)
	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then insert record, 
	# otherwise do nothing (that is, just display html for create)
	if ( !empty($_POST)) {
		// keep track validation errors
		$usernameError = null;
		$passwordError = null;
		$firstNameError = null;
    $lastNameError = null;
		
		// keep track post values
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $dietType = $_POST['dietType'];
    $favFood = $_POST['favFood'];
		
		// validate input
		$valid = true;
		if (empty($username)) {
			$usernameError = 'Please enter User Name';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter a password';
			$valid = false;
		}
		
		if (empty($firstName)) {
			$firstNameError = 'Please enter First Name';
			$valid = false;
		}
    
    if (empty($lastName)) {
			$lastNameError = 'Please enter Last Name';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO User (UserName,password,firstName,lastName,DietType,FavoriteFood) values(?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($username,$password,$firstName,$lastName,$dietType,$favFood));
			Database::disconnect();
			header("Location: Profile.php");
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
		    			<h3>Create User</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create.php" method="post">
					
					  <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					    <label class="control-label">UserName</label>
					    <div class="controls">
					      	<input name="username" type="text"  placeholder="UserName" value="<?php echo !empty($username)?$username:'';?>">
					      	<?php if (!empty($usernameError)): ?>
					      		<span class="help-inline"><?php echo $usernameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="text" placeholder="Enter Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
            
					  <div class="control-group <?php echo !empty($firstNameError)?'error':'';?>">
					    <label class="control-label">First Name</label>
					    <div class="controls">
					      	<input name="firstName" type="text"  placeholder="First Name" value="<?php echo !empty($firstName)?$firstName:'';?>">
					      	<?php if (!empty($firstNameError)): ?>
					      		<span class="help-inline"><?php echo $firstNameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
            
            <div class="control-group <?php echo !empty($lastNameError)?'error':'';?>">
					    <label class="control-label">Last Name</label>
					    <div class="controls">
					      	<input name="lastName" type="text"  placeholder="Last Name" value="<?php echo !empty($lastName)?$lastName:'';?>">
					      	<?php if (!empty($lastNameError)): ?>
					      		<span class="help-inline"><?php echo $lastNameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
            
            <div class="control-group">
					    <label class="control-label">Diet Type</label>
					    <div class="controls">
					      <input name="dietType" type="text"  placeholder="Vegetarian, Vegan, Paleo, etc." value="<?php echo !empty($dietType)?$dietType:'';?>">
					    </div>
					  </div>
            
            <div class="control-group">
					    <label class="control-label">Favorite Food</label>
					    <div class="controls">
					      <input name="favFood" type="text"  placeholder="Pizza, Spagetti, Curry, etc." value="<?php echo !empty($favFood)?$favFood:'';?>">
					    </div>
					  </div>
            
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="login.php">Back</a>
						</div>
						
					</form>
					
				</div>
				
    </div> <!-- /container -->
  </body>
</html>