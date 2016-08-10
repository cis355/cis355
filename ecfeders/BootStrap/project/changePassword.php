<?php
/* *******************************************************************  
* filename     : chnagePassword.php  
* author       : Erik Federspiel & Start Bootstrap & Star Tutorial
*  				 https://startbootstrap.com/template-overviews/simple-sidebar/
				 https://www.startutorial.com/
* username     : ecfeders  
* course       : cs355  
* section      : 11-MW  
* semester : Summer 2016  
*  
* description  : php file lets the user update their password
 *  
 * processing   : The program steps are as follows.   
 *          1. display form
 *          2. wait for button click
 *          3. after button click go to correct form 
 *          4. based on button click do operations  
 
 * output       : updated password information in the worker table
 *  
 * precondition : css documents and php files in the same folder/requires databaseProject.php
 * postcondition: updates user password
 * *******************************************************************   */ 
 ?>

<?php
    //Make sure logged in
	session_start();
	if(empty($_SESSION['name'])){
		header("Location: loginProject.php"); // redirect 
    }
?>

<?php 
	//Connect to database and get id
	require 'databaseProject.php';
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	//Check error checking
	if ( !empty($_POST)) {
		
		// keep track validation errors
		$password2 = null;
		$passwordError = null;

		// keep track post values
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		
		// validate input
		$valid = true;
		if ($password != $password2) {
			//exit();
			$passwordError = 'The Passwords Do Not Match';
			$valid = false;
		}
		//CIf valid update else populate the form with the sheet data
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE workers set password = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($password,$id));
			Database::disconnect();
			
			header("Location: project.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<link href="css/create.css" rel="stylesheet">
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Update Password</h3>
		    		</div>
					
					<!-- Form lets the user update a record in the form
					-->
	    			<form class="form-horizontal" action="changePassword.php?id=<?php echo $id?>" method="POST">
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">New Password</label>
					    <div class="controls">
					      	<input name="password" type="password"  placeholder="new password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Confirm Password</label>
					    <div class="controls">
					      	<input name="password2" type="password" placeholder="confirm password" value="<?php echo !empty($password2)?$password2:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <input type="submit" class="btn btn-success" name="submit" value="Update">
						  <a class="btn btn-info" href="project.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>