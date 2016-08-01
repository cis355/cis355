<?php 

	session_start();

	# Consider three scenarios.
	# 1. User clicked create button on list screen (index.php)
	#		If that happens then create.php displays entry screen
	# 2. User clicked create button (submit button) on entry but one or more fields were empty
	#		If that happens then error message(s) appears next to empty field(s)
	# 3. User clicked create button (submit button) and all data valid
	#		If that happens then PHP code inserts the record and redirect to list screen (index.php)
	
	# includes connection to database and functions
	require 'database.php';
	
	# if there is data passed, then insert record, otherwise do nothing 
	if ( !empty($_POST)) {
		// keep track validation errors
		$userNameError = null;
		$passwordError = null;
		
		// keep track post values
		$campName = $_POST['campName'];
		$startDate = $_POST['startDate'];

		
		// validate input
		$valid = true;
		if (empty($campName)) {
			$campNameError = 'Please enter your camp Name';
			$valid = false;
		}
		if (empty($startDate)) {
			$startDateError = 'Please enter Date';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO campUser (campName,startDate,) values(?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($campName,$startDate));
			Database::disconnect();
			header("Location: camps.php");
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
		    			<h3>Create a User</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="create3.php" method="post">
					<div class="control-group <?php echo !empty($userNameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="userName" type="text"  placeholder="User Name" value="<?php echo !empty($userName)?$userName:'';?>">
					      	<?php if (!empty($userNameError)): ?>
					      		<span class="help-inline"><?php echo $userNameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($startDateError)?'error':'';?>">
					    <label class="control-label">Start Date</label>
					    <div class="controls">
					      	<input name="password" type="password"  placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">Create</button>
						  <a class="btn" href="camps.php">Back</a>
						</div>
					</form>
				</div>
				
    </div> <!-- /container -->
  </body>
</html>