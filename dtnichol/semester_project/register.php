<!--/* *******************************************************************
* filename : register.php
* author : Derek Nichols
* username : dtnichol
* course : cs355
* section : 11-MW
* semester : Summer 2016
*
* description : registration form for new users that will insert them into the database *       		  customers1.                
*               
*
* input : user fills out registration form
* processing : The program steps are as follows.
* 		1. registration form is filled out
* 		2. submits form
* 		3. user is added to customers1 database table
* 		
* output : none
*
* precondition : none
* postcondition: user is registered in customers1 database table
* 				 
* *******************************************************************
*/-->





<?php 

	session_start();
	//if (empty($_SESSION[''])) header("Location: login.php"); //redirect

	//consider three scenarios. 
	//1. user clicked the create buttong on the list screen (index.php)
	//		if that happens then create.php displays blank entry screen
	//2. User clicked the create button (submit button) on the entry screen but one or more fields were empty
	//		If that happens then error message appears nexxt to empty field(s)
	//3. User clicked create button (submit button) and all data valid
	//		If that happens then the PHP code inserts the record and redirects to the list screen (index.php)
	
	// include connection data and functions
	require 'database.php';
	
	//if there was data passed, then insert the record, otherwise do nothing (that is, just display html)
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$emailError = null;
		$mobileError = null;
		$passwordError = null;
		$passwordConfError=null;
		// keep track post values
		$name = $_POST['name'];
		$email = $_POST['email'];
		$mobile = $_POST['mobile'];
		$password = $_POST['password'];
		$passwordConf = $_POST['confPassword'];
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter Name';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter Email Address';
			$valid = false;
		} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
			$emailError = 'Please enter a valid Email Address';
			$valid = false;
		}
		
		if (empty($mobile)) {
			$mobileError = 'Please enter Mobile Number';
			$valid = false;
		}
		
		if (empty($password)) {
			$passwordError = 'Please enter a Password';
			$valid = false;
		}
		//if ($passwordConf!=$password) {
		//	$passwordConfError = 'try again';
		//	$valid = false;
		//} 
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO customers1 (name,email,mobile,password) values(?, ?, ?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$mobile,$password));
			Database::disconnect();
			header("Location: login1.php");
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
	<div id="background"><img class="stretch" src="blue.jpg"/></div>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Register Now</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="register.php" method="post">
					
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email Address</label>
					    <div class="controls">
					      	<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					    <label class="control-label">Mobile Number</label>
					    <div class="controls">
					      	<input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
					      	<?php if (!empty($mobileError)): ?>
					      		<span class="help-inline"><?php echo $mobileError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <!--div class="control-group <?php echo !empty($passwordConfError)?'error':'';?>">
					    <label class="control-label">Password Confirmation</label>
					    <div class="controls">
					      	<input name="passwordConf" type="password"  placeholder="Password" value="<?php echo !empty($passwordConf)?$passwordConf:'';?>">
					      	<?php if (!empty($passwordConfError)): ?>
					      		<span class="help-inline"><?php echo $passwordConfError;?></span>
					      	<?php endif;?>
					    </div>
					  </div-->
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Register</button>
						  <a class="btn" href="index1.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>